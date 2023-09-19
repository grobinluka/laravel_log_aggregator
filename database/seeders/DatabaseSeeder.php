<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use App\Models\User;
use App\Models\Project;
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

        //Default roles seed
        $roles = ['Admin', 'Employee'];

        foreach ($roles as $role){
            if(!Role::whereName($role)->first()){
                Role::create([
                    'name' => $role,
                ]);
            }
        }

        //Default Severity Levels seed
        SeverityLevel::factory(10)->create();
        // $levels = ['Notice', 'Warning', 'Error', 'Critical', 'Emergency'];

        // foreach ($levels as $level){
        //     if(!SeverityLevel::whereLevel($level)->first()){
        //         SeverityLevel::create([
        //             'level' => $level,
        //         ]);
        //     }
        // }

        User::create([
            'name' => 'Luka Grobin',
            'email' => 'grobinluka@gmail.com',
            'password' => '$2y$10$uyZo6QNstLlQeDJ.S2oEuue/eYSI8Wr/SE2DeQoNgudvJNhRCm7O6',
            'role_id' => 1
        ]);
        
        //User SEED - role: employee
        User::factory(10)->state(new Sequence(
                fn(Sequence $sequence) => [
                    'role_id' => Role::whereName('employee')->first()->id
                ],
            ))->create();

        //User SEED - role: admin
        User::factory(1)->state(new Sequence(
                fn(Sequence $sequence) => [
                    'role_id' => Role::whereName('admin')->first()->id
                ],
            ))->create();


        //Project SEED
        Project::factory(5)->create();

        
        // for($i = 0; $i < 35; $i++){

        //     $title = fake()->sentence(3, true);
        //     $slug = fake()->colorName;

        //     while(Project::whereTitle($title)->exists()){
        //         $title = fake()->sentence(3, true);
        //     }

        //     while(Project::whereSlug($slug)->exists()){
        //         $slug = fake()->colorName;
        //     }

        //     Project::factory()->state(new Sequence(
        //         fn(Sequence $sequence) => [
        //             'title' => $title,
        //             'slug' => $slug,
        //         ],
        //     ))->create();
        // }

        //Assign Users to Projects
        \App\Models\ProjectUser::factory(20)->create();


        \App\Models\Log::factory(10)->create();
    }
}
