<?php

namespace Database\Seeders;

use App\Enums\TicketCategoryEnum;
use App\Enums\TicketClassificationEnum;
use App\Enums\TicketServiceTypeEnum;
use App\Enums\TicketSeverityEnum;
use App\Enums\TicketStatusEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tickets;
use App\Models\User;
use Carbon\Carbon;

class TicketsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        // Map enum values
        $categories = array_map(fn($val) => $val->value, TicketCategoryEnum::cases());
        $classifications = array_map(fn($val) => $val->value, TicketClassificationEnum::cases());
        $serviceTypes = array_map(fn($val) => $val->value, TicketServiceTypeEnum::cases());
        $severities = array_map(fn($val) => $val->value, TicketSeverityEnum::cases());

        $ticketData = collect(range(1, 20))->map(function () use ($users, $categories, $classifications, $serviceTypes, $severities) {
            $reporter = $users->random();
            $assignee = $users->random();

            // Random status
            $statusOptions = array_map(fn($val) => $val->value, TicketStatusEnum::cases());
            $status = $statusOptions[array_rand($statusOptions)];

            $dateReported = Carbon::now()->subDays(rand(1, 10));
            $dateClosed = in_array($status, ['Resolved', 'CLOSED']) ? $dateReported->copy()->addHours(rand(1, 72)) : null;

            return [
                'title' => fake()->sentence(rand(3, 6)),
                'description' => fake()->paragraph(),
                'status' => $status,
                'image' => null,
                'assignee_id' => $assignee->id,
                'reporter_id' => $reporter->id,
                'reporter_email' => $reporter->email,
                'assignee_email' => $assignee->email,
                'category' => $categories[array_rand($categories)],
                'classification' => $classifications[array_rand($classifications)],
                'service_type' => $serviceTypes[array_rand($serviceTypes)],
                'date_reported' => $dateReported,
                'date_closed' => $dateClosed,
                'severity' => $severities[array_rand($severities)],
                'reporter_department' => $reporter->department,
                'resolution' => in_array($status, ['CLOSED']) ? 'Issue resolved successfully.' : null,
                'assignee_team' => $assignee->team,
                'performance' => 'Good',
                'sla' => rand(1, 5),
                'tat' => rand(1, 5),
                'total_tat' => rand(1, 10),
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->toArray();

        Tickets::insert($ticketData);
    }
}
