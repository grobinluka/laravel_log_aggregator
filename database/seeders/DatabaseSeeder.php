<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Log;
use App\Models\Role;
use App\Models\User;
use App\Models\Project;
use App\Models\ProjectUser;
use Illuminate\Support\Str;
use App\Models\SeverityLevel;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // Default roles seed
        $roles = ['Admin', 'Employee'];

        foreach ($roles as $role) {
            if (!Role::whereName($role)->first()) {
                Role::create([
                    'name' => $role,
                ]);
            }
        }

        // Default Severity Levels seed
        $levels = [
                'Debug'
                ,'Informational'
                ,'Notice'
                ,'Warning'
                ,'Error'
                ,'Critical'
                ,'Alert'
                ,'Emergency'
            ];

        foreach ($levels as $level) {
            if (!SeverityLevel::whereLevel($level)->first()) {
                SeverityLevel::create([
                    'level' => $level,
                ]);
            }
        }

        // Create an admin user if it doesn't exist
        if (!User::whereEmail('admin@gmail.com')->first()){
            User::create([
                'name' => 'Administrator',
                'email' => 'admin@gmail.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$uyZo6QNstLlQeDJ.S2oEuue/eYSI8Wr/SE2DeQoNgudvJNhRCm7O6',
                'role_id' => 1,
                'remember_token' => Str::random(10),
            ]);
        }

        if (!User::whereEmail('tester@gmail.com')->first()){
            User::create([
                'name' => 'Tester User',
                'email' => 'tester@gmail.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$uyZo6QNstLlQeDJ.S2oEuue/eYSI8Wr/SE2DeQoNgudvJNhRCm7O6',
                'role_id' => 2,
                'remember_token' => Str::random(10),
            ]);
        }

        // User SEED - role: employee
        User::factory(10)->state(new Sequence(
            fn(Sequence $sequence) => [
                'role_id' => Role::whereName('employee')->first()->id,
            ],
        ))->create();

        // Project Seed
        Project::factory(10)->create();

        // ProjectUser Seed
        ProjectUser::factory(50)->create();

        // Log Seed
        // Log::factory(1000)->create();

    }
}
