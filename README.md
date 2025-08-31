# CCS4360 - Laravel Social Auth Project

A Laravel application demonstrating user authentication via Google OAuth (using Laravel Socialite) and integration with Google APIs (Gmail, Calendar, Tasks) to display user data.

## Features

*   **Google OAuth Login:** Users can securely log in using their Google accounts.
*   **Dashboard:** A central hub after successful login.
*   **Google API Integration:** Fetches and displays user data from:
    *   **Google Calendar:** Upcoming events in a clean table.
    *   **Gmail:** Latest emails with sender, subject, and date.
    *   **Google Tasks:** Current tasks with their status and due dates.
*   **Responsive UI:** Built with Laravel Breeze for a clean and functional interface.


## Prerequisites

Before you begin, ensure you have the following installed on your local machine:
*   PHP (>= 8.1)
*   Composer
*   Node.js and npm
*   Git
*   A local development environment (Laragon)

## Installation & Setup

Follow these steps to get the project running on your local machine.

### 1. Clone the Repository
```bash
git clone https://github.com/tashima39/Laravel-Social-Auth.git
cd Laravel-Social-Auth 
```

### 2. Install PHP Dependencies
```bash
composer install
```

### 3. Install NPM Dependencies and Build Assets
```bash
npm install
npm run build
```

### 4. Environment Configuration
Copy the example environment file and generate an application key.
```bash
cp .env.example .env
php artisan key:generate
```

Edit the `.env` file and configure your database connection (SQLite, MySQL). For a simple setup with SQLite:
```bash
touch database/database.sqlite
```
Then set in your `.env`:
```
DB_CONNECTION=sqlite
```

### 5. Database Migration
Run the migrations to create the necessary tables, including the modified `users` table for storing Google tokens.
```bash
php artisan migrate
```

### 6. Google OAuth Setup
This is a crucial step for the application to function.

1.  Go to the [Google Cloud Console](https://console.cloud.google.com/).
2.  Create a new project or select an existing one.
3.  Configure the **OAuth consent screen** (External).
4.  Navigate to **Credentials** and create a new **OAuth 2.0 Client ID**.
5.  Set the **Application type** to `Web application`.
6.  Under **Authorized redirect URIs**, add:
    `http://127.0.0.1:8000/auth/google/callback`
7.  Note down your `Client ID` and `Client Secret`.

Now, add these credentials to your Laravel `.env` file:
```
GOOGLE_CLIENT_ID=your_google_client_id_here
GOOGLE_CLIENT_SECRET=your_google_client_secret_here
GOOGLE_REDIRECT_URI=http://127.0.0.1:8000/auth/google/callback
```

Also, ensure these are linked in `config/services.php`:
```php
'google' => [
    'client_id' => env('GOOGLE_CLIENT_ID'),
    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
    'redirect' => env('GOOGLE_REDIRECT_URI'),
],
```

### 7. Clear Configuration Cache
It's essential to clear any cached configuration to ensure your new `.env` settings are loaded.
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### 8. Run the Application
You can now start the Laravel development server:
```bash
php artisan serve
```
For frontend css, run in a separate terminal:
```bash
npm run dev
```

Visit `http://127.0.0.1:8000` in your browser. Click **Login**, then **Continue with Google** to test the authentication flow.

## Usage

1.  Navigate to the application's login page.
2.  Click on "Continue with Google".
3.  You will be redirected to Google to authenticate and grant permissions.
4.  Upon successful authentication, you will be redirected to the dashboard.
5.  From the dashboard, you can navigate to the Calendar, Emails, and To-Dos pages to view your data fetched from your Google account.


## Technologies Used

*   **Backend:** Laravel (PHP)
*   **Authentication:** Laravel Breeze, Laravel Socialite
*   **Google APIs:** Google API Client Library
*   **Frontend:** Blade Templating, Tailwind CSS
*   **Database:** SQLite
*   **Development:** Laragon

---

This project was completed for CCS4360 Techniques in Social Media assignment.

```
