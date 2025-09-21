<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
use App\Models\User;

class TestWelcomeEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:welcome {email? : Email address to send welcome email to}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test welcome email';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $email = $this->argument('email') ?: 'buituyenkc2004@gmail.com';
        
        $this->info('📧 Preparing to send welcome email...');
        $this->info("📮 Recipient: {$email}");
        
        try {
            // Create a mock user for testing
            $mockUser = new User([
                'name' => 'Test User',
                'email' => $email,
            ]);
            
            $this->info('🚀 Sending welcome email...');
            
            Mail::to($email)->send(new WelcomeMail($mockUser));
            
            $this->info('✅ Welcome email sent successfully!');
            $this->info('📬 Please check your inbox for the welcome email');
            
            return Command::SUCCESS;
            
        } catch (\Exception $e) {
            $this->error('❌ Failed to send welcome email');
            $this->error('Error: ' . $e->getMessage());
            
            return Command::FAILURE;
        }
    }
}