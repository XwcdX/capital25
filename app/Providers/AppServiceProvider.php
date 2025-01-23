<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Log;
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
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            if ($notifiable instanceof Admin) {
                $view = 'admin.mail.verify-email';
            } elseif ($notifiable instanceof Team) {
                $view = 'user.mail.verify-email';
            }
            return (new MailMessage())
                ->view($view, [
                    'url' => $url,
                    'user' => $notifiable,
                ]);
        });
    }
}
