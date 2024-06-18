<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Department;
use App\Models\Level;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Admin::factory(10)->create();
       // Department::factory(10)->create();
        Level::factory(10)->create();
        //User::factory(10)->create();
        //Notification::factory(100)->event()->create();
        //Notification::factory(100)->notification()->create();
        // \App\Models\User::factory(10)->create();
    }
}
