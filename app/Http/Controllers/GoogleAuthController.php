<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Services\GoogleService;

class GoogleAuthController extends Controller
{
    public function login() {
        return view('auth.login');
    }

    public function redirect()
    {
        $scopes = [
            'openid', 
            'profile', 
            'email',
            'https://www.googleapis.com/auth/calendar.readonly',
            'https://www.googleapis.com/auth/gmail.readonly',
            'https://www.googleapis.com/auth/tasks.readonly',
        ];
        
        return Socialite::driver('google')
            ->stateless() 
            ->scopes($scopes)
            ->with(['access_type' => 'offline', 'prompt' => 'consent select_account'])
            ->redirect();
    }

    public function callback(GoogleService $google)
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Debug: check what Google returns
            \Log::info('Google User Data: ', [
                'email' => $googleUser->getEmail(),
                'id' => $googleUser->getId(),
                'token' => $googleUser->token ? 'exists' : 'missing',
                'refresh_token' => $googleUser->refreshToken ? 'exists' : 'missing'
            ]);

            $user = User::updateOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName() ?? $googleUser->getNickname(),
                    'google_id' => $googleUser->getId(),
                    'google_token' => $googleUser->token,
                    'google_refresh_token' => $googleUser->refreshToken,
                ]
            );
            
            Auth::login($user, true);
            
            // Regenerate session to prevent fixation attacks
            session()->regenerate();
            
            return redirect()->route('dashboard');
            
        } catch (\Exception $e) {
            \Log::error('Google Auth Error: ' . $e->getMessage());
            return redirect()->route('login')->withErrors('Google login failed: ' . $e->getMessage());
        }
    }

    public function dashboard(GoogleService $google)
    {
        if (!$this->ensureTokens()) {
            return redirect()->route('google.redirect');
        }
        
        $google->setUserTokens(Auth::user());
        return view('dashboard');
    }

    public function calendar(GoogleService $google)
    {
        if (!$this->ensureTokens()) {
            return redirect()->route('google.redirect');
        }
        
        $google->setUserTokens(Auth::user());
        $events = $google->getUpcomingEvents(10);
        return view('calendar', compact('events'));
    }

    public function emails(GoogleService $google)
    {
        if (!$this->ensureTokens()) {
            return redirect()->route('google.redirect');
        }
        
        $google->setUserTokens(Auth::user());
        $emails = $google->getLatestEmails(10);
        return view('emails', compact('emails'));
    }

    public function todos(GoogleService $google)
    {
        if (!$this->ensureTokens()) {
            return redirect()->route('google.redirect');
        }
        
        $google->setUserTokens(Auth::user());
        $tasks = $google->getTasks(15);
        return view('todos', compact('tasks'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    private function ensureTokens()
    {
        if (!Auth::check()) {
            return false;
        }
        
        $user = Auth::user();
        
        // Check if user has tokens
        if (!$user->google_token) {
            return false;
        }
        
        return true;
    }
}