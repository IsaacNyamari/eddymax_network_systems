<?php

namespace Database\Seeders;

use App\Models\Notifications;
use App\Models\User;
use Illuminate\Database\Seeder;

class NotificationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get a user to associate with notifications
        // $user = User::first();

        // if (!$user) {
        //     // Create a user if none exists
        //     $user = User::factory()->create();
        // }

        // Create notifications using the relationship (RECOMMENDED)
        // $user->notifications()->create([
        //     "message" => "new order from client",
        //     "type" => "order"
        // ]);

        // Or create multiple notifications
        // $user->notifications()->createMany([
        //     [
        //         "message" => "new order from client",
        //         "type" => "order"
        //     ],
        //     [
        //         "message" => "payment received",
        //         "type" => "payment"
        //     ],
        //     [
        //         "message" => "welcome to our platform",
        //         "type" => "welcome"
        //     ]
        // ]);

        // Or use Notification model directly
        Notifications::create([
            "notifiable_id" => 1,
            "notifiable_type" => User::class,
            "message" => "system notification",
            "type" => "system"
        ]);

        // // Create notifications for multiple users
        // $users = User::take(5)->get();

        // foreach ($users as $user) {
        //     $user->notifications()->create([
        //         "message" => "Notification for user " . $user->id,
        //         "type" => "user_notification"
        //     ]);
        // }
    }
}
