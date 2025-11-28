<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tickets;
use App\Models\User;

class TicketsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create some users first if they don't exist
        $users = User::factory(5)->create();

        $ticketData = [
            [
                'title' => 'Website Login Issue',
                'description' => 'Users are unable to log in to the website. Getting error 500 when trying to access the login page.',
                'status' => 'Open',
                'priority' => 'High',
                'assignee_id' => $users->random()->id,
                'reporter_id' => $users->random()->id,
            ],
            [
                'title' => 'Database Connection Error',
                'description' => 'Application is showing database connection errors in production environment.',
                'status' => 'In Progress',
                'priority' => 'Critical',
                'assignee_id' => $users->random()->id,
                'reporter_id' => $users->random()->id,
            ],
            [
                'title' => 'Email Notifications Not Working',
                'description' => 'Users are not receiving email notifications for password reset and account verification.',
                'status' => 'Open',
                'priority' => 'Medium',
                'assignee_id' => $users->random()->id,
                'reporter_id' => $users->random()->id,
            ],
            [
                'title' => 'Mobile App Crashes on iOS',
                'description' => 'Mobile application crashes immediately after launch on iOS devices running version 15.0.',
                'status' => 'Resolved',
                'priority' => 'High',
                'assignee_id' => $users->random()->id,
                'reporter_id' => $users->random()->id,
            ],
            [
                'title' => 'Payment Gateway Integration Issue',
                'description' => 'Payment processing is failing for credit card transactions. Error code: PAYMENT_DECLINED.',
                'status' => 'In Progress',
                'priority' => 'Critical',
                'assignee_id' => $users->random()->id,
                'reporter_id' => $users->random()->id,
            ],
            [
                'title' => 'User Profile Update Bug',
                'description' => 'Users cannot update their profile information. Form submission fails with validation errors.',
                'status' => 'Open',
                'priority' => 'Low',
                'assignee_id' => $users->random()->id,
                'reporter_id' => $users->random()->id,
            ],
            [
                'title' => 'Search Functionality Broken',
                'description' => 'Search feature is not returning any results regardless of the search term entered.',
                'status' => 'Closed',
                'priority' => 'Medium',
                'assignee_id' => $users->random()->id,
                'reporter_id' => $users->random()->id,
            ],
            [
                'title' => 'File Upload Size Limit',
                'description' => 'Users cannot upload files larger than 1MB. Need to increase the file size limit to 10MB.',
                'status' => 'Open',
                'priority' => 'Low',
                'assignee_id' => $users->random()->id,
                'reporter_id' => $users->random()->id,
            ],
            [
                'title' => 'API Rate Limiting Issue',
                'description' => 'API is returning 429 errors too frequently. Rate limiting needs to be adjusted.',
                'status' => 'In Progress',
                'priority' => 'Medium',
                'assignee_id' => $users->random()->id,
                'reporter_id' => $users->random()->id,
            ],
            [
                'title' => 'Dashboard Performance Slow',
                'description' => 'Admin dashboard is loading very slowly. Page load time is over 10 seconds.',
                'status' => 'Resolved',
                'priority' => 'High',
                'assignee_id' => $users->random()->id,
                'reporter_id' => $users->random()->id,
            ],
        ];

        foreach ($ticketData as $ticket) {
            Tickets::create($ticket);
        }
    }
}
