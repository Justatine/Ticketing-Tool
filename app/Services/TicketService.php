<?php

namespace App\Services;

use App\Enums\RoleEnum;
use App\Enums\TicketCategoryEnum;
use App\Enums\TicketClassificationEnum;
use App\Enums\TicketPerformanceEnum;
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

        if (isset($data['status']) && $data['status'] === TicketStatusEnum::CLOSED->value) {
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
                $data['performance'] = TicketPerformanceEnum::PASS->value;
            } else {
                $data['sla'] = 0.00;
                $data['performance'] = TicketPerformanceEnum::FAIL->value;
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
     * Get all user form options for dropdowns.
     */
    public function getTicketCardData(): array
    {
        $user_id = Auth::id();

        return [
            'total_open_new' => Tickets::whereIn('status', [TicketStatusEnum::NEW->value, TicketStatusEnum::OPEN->value])->where('assignee_id',$user_id)->count(),
            'total_inprog' => Tickets::where('status', TicketStatusEnum::INPROG->value)->where('assignee_id',$user_id)->count(),
            'total_closed' => Tickets::where('status', TicketStatusEnum::CLOSED->value)->where('assignee_id',$user_id)->count(),
            // 'total_unresolved' => Tickets::where('status', '!=', TicketStatusEnum::CLOSED)
            //     ->whereNull('date_closed')
            //     ->where('assignee_id',$user_id)
            //     ->count(),
            'total_pending' => Tickets::where('status', TicketStatusEnum::PENDING->value)->where('assignee_id',$user_id)->count(),
            'total_failed_unresolved' => Tickets::whereNotNull('date_closed')
                ->whereRaw('date_closed > DATE_ADD(date_reported, INTERVAL 3 HOUR)')
                ->where('assignee_id',$user_id)
                ->count(),
            'total_voided' => Tickets::where('status', TicketStatusEnum::VOID->value)->where('assignee_id',$user_id)->count(),
        ];
    }

    /**
     * Get all assignees for dropdown.
     */
    public function getTickets(): array
    {
        $user_id = Auth::id();

        return Tickets::with(['assignee', 'reporter'])
            ->where(function($query) use ($user_id) {
                $query->where('assignee_id', $user_id);
                    // ->orWhere('reporter_id', $user_id);
            })
            ->orderByRaw("
                CASE WHEN status != ? THEN 0 ELSE 1 END
            ", [TicketStatusEnum::CLOSED->value])
            ->orderByRaw("
                FIELD(severity, ?, ?, ?, ?)
            ", [
                TicketSeverityEnum::CRITICAL->value,
                TicketSeverityEnum::HIGH->value,
                TicketSeverityEnum::NORMAL->value,
                TicketSeverityEnum::LOW->value
            ])
            ->filter(request(['search', 'assignee_id']))
            ->latest()
            ->paginate(6)
            ->withQueryString()
            ->toArray();
    }

    /**
     * Get all assignees for dropdown.
     */
    public function getTicketAssignees(): array
    {
        $userID = Auth::id();

        return User::where('role', '<>', RoleEnum::SA->value)
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
