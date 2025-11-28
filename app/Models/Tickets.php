<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

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
        'region',
        'resolution',
        'performance',
        'sla',
        'tat',
        'total_tat',
    ];


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
