<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;

class TestEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test {email? : Email address to send test email to}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test email to verify SMTP configuration';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $email = $this->argument('email') ?: 'buituyenkc2004@gmail.com';
        
        $this->info('📧 Preparing to send test email...');
        $this->info("📮 Recipient: {$email}");
        
        try {
            // Test configuration
            $this->info('🔧 Testing email configuration...');
            
            $this->table(['Setting', 'Value'], [
                ['MAIL_MAILER', config('mail.default')],
                ['MAIL_HOST', config('mail.mailers.smtp.host')],
                ['MAIL_PORT', config('mail.mailers.smtp.port')],
                ['MAIL_USERNAME', config('mail.mailers.smtp.username')],
                ['MAIL_ENCRYPTION', config('mail.mailers.smtp.encryption')],
                ['FROM_ADDRESS', config('mail.from.address')],
                ['FROM_NAME', config('mail.from.name')],
                ['TIMEZONE', config('app.timezone')],
                ['CURRENT_TIME', now()->format('Y-m-d H:i:s T')],
            ]);
            
            $this->info('🚀 Sending test email...');
            
            Mail::to($email)->send(new TestMail());
            
            $this->info('✅ Test email sent successfully!');
            $this->info('📬 Please check your inbox (and spam folder)');
            
            return Command::SUCCESS;
            
        } catch (\Exception $e) {
            $this->error('❌ Failed to send test email');
            $this->error('Error: ' . $e->getMessage());
            
            $this->info('🔍 Troubleshooting tips:');
            $this->line('1. Check your Gmail app password is correct');
            $this->line('2. Ensure 2-factor authentication is enabled on Gmail');
            $this->line('3. Verify the app password was created correctly');
            $this->line('4. Check firewall/antivirus settings');
            
            return Command::FAILURE;
        }
    }
}