<?php

namespace App\Services;

use App\Enums\TicketCategoryEnum;
use App\Enums\TicketClassificationEnum;
use App\Enums\TicketServiceTypeEnum;
use App\Enums\TicketSeverityEnum;
use App\Enums\TicketStatusEnum;
use App\Models\Tickets;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TicketService
{
    /**
     * Store a new user.
     */
    public function store(array $data): Tickets
    {
        $data['status'] = 'NEW';
        $data['reporter_email'] = User::find($data['reporter_id'])?->email;
        $data['assignee_email'] = User::find($data['assignee_id'])?->email;
        $data['date_reported'] = Carbon::now()->format('Y-m-d H:i:s');
        $data['reporter_department'] = User::find($data['reporter_id'])?->department;
        $data['assignee_team'] = User::find($data['assignee_id'])?->team;
        $data['performance'] = 'ONGOING';
        $data['sla'] = 0.80;
        $data['tat'] = 0.00;
        $data['total_tat'] = 0.00;
        $data['resolution'] = null;

        return Tickets::create($data);
    }

    /**
     * Update an existing user.
     */
    public function update(Tickets $ticket, array $data): Tickets
    {
        $data['assignee_email'] = User::find($data['assignee_id'])?->email;
        $data['assignee_team'] = User::find($data['assignee_id'])?->team;

        if (isset($data['status']) && $data['status'] === 'CLOSED') {
            $data['date_closed'] = Carbon::now();

            $dateReported = Carbon::parse($ticket->date_reported);
            $dateClosed = Carbon::parse($data['date_closed']);

            $tatHours = $dateReported->diffInMinutes($dateClosed) / 60;
            $data['tat'] = round($tatHours, 2);
            $data['total_tat'] = round($tatHours, 2);

            // Calculate SLA - assuming 4 hour target
            $targetHours = 4;
            if ($tatHours <= $targetHours) {
                $data['sla'] = 1.00;
            } else {
                $data['sla'] = 0.00;
            }

            // Calculate SLA as percentage of target
            $data['sla'] = min(1.00, $targetHours / $tatHours);
        }
        $ticket->update($data);
        return $ticket->fresh();
    }

    /**
     * Delete a user.
     */
    public function destroy(Tickets $user): void
    {
        $user->delete();
    }

    /**
     * Get all assignees for dropdown.
     */
    public function getTickets(): array
    {
        return Tickets::with(['assignee', 'reporter'])
            ->filter(request(['search', 'assignee_id']))
            ->latest()
            ->paginate(5)
            ->withQueryString()
            ->toArray();
    }

    /**
     * Get all assignees for dropdown.
     */
    public function getTicketAssignees(): array
    {
        $userID = Auth::id();

        return User::where('role', '<>','Admin')
            ->where('id','<>',$userID)
            ->select('id','name')
            ->orderBy('name')
            ->get()
            ->map(fn($x) => [
                'value' => $x->id,
                'label' => $x->name,
            ])
            ->toArray();
    }

    /**
     * Get all regions for dropdown.
     */
    public function getStatus(): array
    {
        return collect(TicketStatusEnum::cases())->map(fn($val) => [
            'value' => $val->value,
            'label' => $val->label(),
        ])->toArray();
    }

    /**
     * Get all regions for dropdown.
     */
    public function getCategories(): array
    {
        return collect(TicketCategoryEnum::cases())->map(fn($val) => [
            'value' => $val->value,
            'label' => $val->label(),
        ])->toArray();
    }

    /**
     * Get all classifications for dropdown.
     */
    public function getClassifications(): array
    {
        return collect(TicketClassificationEnum::cases())->map(fn($val) => [
            'value' => $val->value,
            'label' => $val->label(),
        ])->toArray();
    }

    /**
     * Get all regions for dropdown.
     */
    public function getServiceTypes(): array
    {
        return collect(TicketServiceTypeEnum::cases())->map(fn($val) => [
            'value' => $val->value,
            'label' => $val->label(),
        ])->toArray();
    }

    public function getTicketSeverity(): array
    {
        return collect(TicketSeverityEnum::cases())->map(fn($val) => [
            'value' => $val->value,
            'label' => $val->label(),
        ])->toArray();
    }
}
