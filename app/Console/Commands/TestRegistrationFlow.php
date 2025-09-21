<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Events\UserRegistered;
use Illuminate\Support\Facades\Hash;

class TestRegistrationFlow extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:registration {email? : Email address for test registration}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the complete registration flow including welcome email';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $email = $this->argument('email') ?: 'buituyenkc2004@gmail.com';
        
        $this->info('🧪 Testing registration flow...');
        $this->info("📧 Test email: {$email}");
        
        try {
            // Check if user already exists
            $existingUser = User::where('email', $email)->first();
            if ($existingUser) {
                $this->warn('⚠️  User already exists with this email. Using existing user for test.');
                $user = $existingUser;
            } else {
                // Create test user
                $this->info('👤 Creating test user...');
                $user = User::create([
                    'name' => 'Test User ' . now()->format('H:i:s'),
                    'email' => $email,
                    'password' => Hash::make('password123'),
                    'role' => 'customer',
                ]);
                $this->info('✅ Test user created successfully');
            }
            
            // Display user info
            $this->table(['Field', 'Value'], [
                ['ID', $user->id],
                ['Name', $user->name],
                ['Email', $user->email],
                ['Role', $user->role],
                ['Created', $user->created_at->format('Y-m-d H:i:s')],
            ]);
            
            // Trigger the registration event
            $this->info('🚀 Triggering UserRegistered event...');
            event(new UserRegistered($user));
            
            $this->info('✅ Registration flow completed successfully!');
            $this->info('📬 Welcome email should be sent automatically');
            $this->info('📋 Check your email inbox for:');
            $this->line('   1. Email verification (if new user)');
            $this->line('   2. Welcome email with beautiful template');
            
            $this->newLine();
            $this->info('🔍 You can check the logs for email sending status:');
            $this->line('   tail -f storage/logs/laravel.log');
            
            return Command::SUCCESS;
            
        } catch (\Exception $e) {
            $this->error('❌ Registration flow test failed');
            $this->error('Error: ' . $e->getMessage());
            
            return Command::FAILURE;
        }
    }
}