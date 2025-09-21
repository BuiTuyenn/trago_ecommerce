<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Log;

class SendWelcomeEmail implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        try {
            // Gửi email chào mừng
            Mail::to($event->user->email)->send(new WelcomeMail($event->user));
            
            Log::info('Welcome email sent successfully to: ' . $event->user->email);
            
        } catch (\Exception $e) {
            Log::error('Failed to send welcome email to ' . $event->user->email . ': ' . $e->getMessage());
            
            // Có thể thêm logic retry hoặc thông báo admin
            // Không throw exception để không làm gián đoạn quá trình đăng ký
        }
    }

    /**
     * Handle a job failure.
     *
     * @param  \App\Events\UserRegistered  $event
     * @param  \Throwable  $exception
     * @return void
     */
    public function failed(UserRegistered $event, $exception)
    {
        Log::error('Welcome email job failed for user: ' . $event->user->email . ' - ' . $exception->getMessage());
    }
}