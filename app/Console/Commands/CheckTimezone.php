<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckTimezone extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:timezone';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check current timezone configuration';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('🕐 Timezone Configuration Check');
        $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        
        // Display timezone info
        $this->table(['Setting', 'Value'], [
            ['Laravel Timezone', config('app.timezone')],
            ['PHP Default Timezone', date_default_timezone_get()],
            ['Current Date/Time (Laravel)', now()->format('Y-m-d H:i:s T')],
            ['Current Date/Time (PHP)', date('Y-m-d H:i:s T')],
            ['UTC Time', now('UTC')->format('Y-m-d H:i:s T')],
        ]);
        
        $this->info('✅ Timezone check completed!');
        
        // Test with database
        try {
            $user = \App\Models\User::first();
            if ($user) {
                $this->line('📅 Sample user created_at: ' . $user->created_at->format('Y-m-d H:i:s T'));
            }
        } catch (\Exception $e) {
            $this->warn('⚠️  Could not fetch user data for timezone test');
        }
        
        return Command::SUCCESS;
    }
}