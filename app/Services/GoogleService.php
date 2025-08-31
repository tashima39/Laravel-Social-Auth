<?php

namespace App\Services;

use Google\Client as GoogleClient;
use Google\Service\Calendar as GoogleCalendar;
use Google\Service\Gmail as GoogleGmail;
use Google\Service\Tasks as GoogleTasks;
use Illuminate\Support\Facades\Auth;

class GoogleService
{
    private GoogleClient $client;

    public function __construct()
    {
        $this->client = new GoogleClient();
        $this->client->setClientId(config('services.google.client_id'));
        $this->client->setClientSecret(config('services.google.client_secret'));
        $this->client->setRedirectUri(config('services.google.redirect'));
        $this->client->setAccessType('offline');
        $this->client->setIncludeGrantedScopes(true);
    }

    // set user tokens after login
    public function setUserTokens($user)
    {
        if (!$user || !$user->google_token) {
            return;
        }

        $this->client->setAccessToken([
            'access_token'  => $user->google_token,
            'refresh_token' => $user->google_refresh_token,
            'expires_in'    => 3600,
            'created'       => time(),
        ]);

        if ($this->client->isAccessTokenExpired() && $user->google_refresh_token) {
            $newToken = $this->client->fetchAccessTokenWithRefreshToken($user->google_refresh_token);

            if (isset($newToken['access_token'])) {
                $user->google_token = $newToken['access_token'];
                $user->save();
                $this->client->setAccessToken($newToken);
            }
        }
    }

    public function getUpcomingEvents(int $limit = 10): array
    {
        try {
            $service = new GoogleCalendar($this->client);
            $events = $service->events->listEvents('primary', [
                'maxResults' => $limit,
                'orderBy'    => 'startTime',
                'singleEvents'=> true,
                'timeMin'    => date('c'),
            ])->getItems();

            return array_map(function ($e) {
                $start = $e->start->dateTime ?: $e->start->date;
                $end   = $e->end->dateTime ?: $e->end->date;
                return [
                    'summary' => $e->summary ?? '(No title)',
                    'start'   => $start,
                    'end'     => $end,
                    'creator' => $e->creator->email ?? '',
                ];
            }, $events ?? []);
        } catch (\Exception $e) {
            \Log::error('Google Calendar Error: ' . $e->getMessage());
            return [];
        }
    }

    public function getLatestEmails(int $limit = 10): array
    {
        try {
            $gmail = new GoogleGmail($this->client);
            $list  = $gmail->users_messages->listUsersMessages('me', ['maxResults' => $limit])->getMessages() ?: [];

            $out = [];
            foreach ($list as $item) {
                $msg = $gmail->users_messages->get('me', $item->getId(), ['format' => 'metadata', 'metadataHeaders'=>['From','Subject','Date']]);
                $headers = collect($msg->getPayload()->getHeaders())->keyBy('name');
                $out[] = [
                    'from'    => $headers['From']->value ?? '',
                    'subject' => $headers['Subject']->value ?? '',
                    'date'    => $headers['Date']->value ?? '',
                ];
            }
            return $out;
        } catch (\Exception $e) {
            \Log::error('Gmail API Error: ' . $e->getMessage());
            return [];
        }
    }

    public function getTasks(int $limit = 20): array
    {
        try {
            $tasks = new GoogleTasks($this->client);
            $taskLists = $tasks->tasklists->listTasklists(['maxResults' => 1])->getItems();
            $listId = $taskLists[0]->id ?? 'primary';

            $items = $tasks->tasks->listTasks($listId, ['maxResults' => $limit])->getItems() ?: [];
            return array_map(fn($t) => [
                'title' => $t->title ?? '',
                'status'=> $t->status ?? '',
                'due'   => $t->due ?? '',
            ], $items);
        } catch (\Exception $e) {
            \Log::error('Google Tasks Error: ' . $e->getMessage());
            return [];
        }
    }
}