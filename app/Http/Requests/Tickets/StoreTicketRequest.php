<?php

namespace App\Http\Requests\Tickets;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'max:255'],
            'description' => ['required', 'string'],
            'status' => ['required', 'max:255'],
            'image' => ['nullable', 'file', 'max:3072', 'mimes:jpeg,jpg,png'],
            'assignee_id' => ['required', 'integer', 'exists:users,id'],
            'reporter_id' => ['required', 'integer', 'exists:users,id'],
            'reporter_email' => ['nullable', 'email', 'exists:users,email'],
            'assignee_email' => ['nullable', 'email', 'exists:users,email'],
            'category' => ['required', 'string', 'max:255'],
            'classification' => ['required', 'string', 'max:255'],
            'service_type' => ['required', 'string', 'max:255'],
            'date_reported' => ['nullable', 'date'],
            'date_closed' => ['nullable', 'date', 'after_or_equal:date_reported'],
            'severity' => ['required', 'string', 'max:255'],
            'resolution' => ['nullable', 'string'],
            'assignee_team' => ['nullable', 'string', 'exists:users,team'],
            'performance' => ['nullable', 'string', 'max:255'],
            'sla' => ['nullable', 'decimal:0,2'],
            'tat' => ['nullable', 'decimal:0,2'],
            'total_tat' => ['nullable', 'decimal:0,2']
        ];
    }
}
