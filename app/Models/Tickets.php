<?php

namespace App\Models;

use App\Enums\DepartmentEnum;
use App\Enums\TeamEnum;
use App\Enums\TicketCategoryEnum;
use App\Enums\TicketClassificationEnum;
use App\Enums\TicketServiceTypeEnum;
use App\Enums\TicketSeverityEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Tickets extends Model
{
    /** @use HasFactory<\Database\Factories\TicketsFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'image',
        'assignee_id',
        'assignee_email',
        'assignee_team',
        'reporter_id',
        'reporter_email',
        'category',
        'classification',
        'service_type',
        'date_reported',
        'date_closed',
        'severity',
        'reporter_department',
        'resolution',
        'performance',
        'sla',
        'tat',
        'total_tat',
    ];

    protected $appends = [
        'category_label',
        'classification_label',
        'service_type_label',
        'severity_label',
        'assignee_team_label',
        'reporter_department_label',
    ];

    protected function reporterDepartmentLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->reporter_department ? DepartmentEnum::from($this->reporter_department)->label() : null,
        );
    }

    protected function assigneeTeamLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->assignee_team ? TeamEnum::from($this->assignee_team)->label() : null,
        );
    }

    protected function severityLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->severity ? TicketSeverityEnum::from($this->severity)->label() : null,
        );
    }

    protected function serviceTypeLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->service_type ? TicketServiceTypeEnum::from($this->service_type)->label() : null,
        );
    }

    protected function classificationLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->classification ? TicketClassificationEnum::from($this->classification)->label() : null,
        );
    }

    protected function categoryLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->category ? TicketCategoryEnum::from($this->category)->label() : null,
        );
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function scopeFilter($query, array $filters)
    {
        if ($filters['search'] ?? false) {
            $query->where(function($f) {
                $f->where('title', 'like', '%'.request('search').'%')
                ->orWhere('description', 'like', '%'.request('search').'%' );
            });
        }

        if ($filters['assignee_id'] ?? false) {
            $query->where('assignee_id', request('assignee_id'));
        }
    }
}
