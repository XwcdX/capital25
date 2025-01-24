<?php

namespace App\Providers;

use Hamcrest\Core\IsInstanceOf;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Admin;
use App\Models\Team;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            $isAdmin = $notifiable instanceof Admin;
            if ($isAdmin) {
                $url = URL::temporarySignedRoute(
                    'admin.verification.verify',
                    now()->addMinutes(config('auth.verification.expire', 60)),
                    [
                        'id' => $notifiable->getKey(),
                        'hash' => sha1($notifiable->getEmailForVerification()),
                    ]
                );
            }
            $view = $isAdmin ? 'admin.mail.verify-email' : 'user.mail.verify-email';
            return (new MailMessage())
                ->view($view, ['url' => $url, 'user' => $notifiable]);
        });
    }
}
