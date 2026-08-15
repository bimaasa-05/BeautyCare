<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;

class DeactivateInactiveUsers extends Command
{
    protected $signature = 'users:deactivate-inactive';
    protected $description = 'Nonaktifkan user yang tidak login selama 1 tahun';

    public function handle()
    {
        $tahunLalu = Carbon::now()->subYear();

        $users = User::where('status', 'aktif')
            ->where(function ($query) use ($tahunLalu) {
                $query->whereNull('last_login_at')
                    ->orWhere('last_login_at', '<', $tahunLalu);
            })
            ->get();

        $count = 0;
        foreach ($users as $user) {
            $user->update(['status' => 'non_aktif']);
            $count++;
            $lastLogin = $user->last_login_at ? $user->last_login_at->format('Y-m-d') : 'belum pernah';
            $this->info("User dinonaktifkan: {$user->email} (last login: {$lastLogin})");
        }

        $this->info("Selesai. {$count} user dinonaktifkan.");
        return Command::SUCCESS;
    }
}
