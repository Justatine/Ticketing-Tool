<?php

namespace App\Http\Controllers;

use App\Http\Middleware\NotAdmin;
use App\Models\Tickets;
use App\Models\User;
use App\Http\Requests\StoreTicketsRequest;
use App\Http\Requests\Tickets\StoreTicketRequest;
use App\Http\Requests\UpdateTicketsRequest;
use App\Services\TicketService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TicketsController extends Controller implements HasMiddleware
{
    protected TicketService $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    public static function middleware(){
        return [
            new Middleware(
                ['auth', 'verified', NotAdmin::class],
                except: ['index','show','edit','create','store','update','destroy']
            )
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Inertia::render('Tickets/Index', [
            'tickets' => $this->ticketService->getTickets(),
            'searchTerm' => $request->search,
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Tickets/Create',[
            'assignees' => $this->ticketService->getTicketAssignees(),
            'categories' => $this->ticketService->getCategories(),
            'classifications' => $this->ticketService->getClassifications(),
            'service_types' => $this->ticketService->getServiceTypes(),
            'severity' => $this->ticketService->getTicketSeverity(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request)
    {
        // dd($request);
        $fields = $request->validated();

        if ($request->hasFile('image')) {
            $fields['image'] =  Storage::disk('public')
                ->put('images/tickets', $request->image);
        }

        $this->ticketService->store($fields);

        return redirect()
            ->route('tickets.index')
            ->with('flash', ['status' => 'Ticket created']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tickets $ticket)
    {
        Gate::authorize('view', $ticket);

        $ticket->load(['assignee', 'reporter']);

        return Inertia::render('Tickets/Show',[
            'ticket' => $ticket,
            // 'canModify' => Auth::user() ?  Auth::user()->can('update',$ticket) : false
            'canModify' => Gate::allows('update', $ticket),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tickets $ticket)
    {
        return Inertia::render('Tickets/Edit',[
            'ticket' => $ticket,
            'assignees' => $this->ticketService->getTicketAssignees(),
            'categories' => $this->ticketService->getCategories(),
            'classifications' => $this->ticketService->getClassifications(),
            'service_types' => $this->ticketService->getServiceTypes(),
            'severity' => $this->ticketService->getTicketSeverity(),
            'statuses' => $this->ticketService->getStatus(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreTicketRequest $request, Tickets $ticket)
    {
        // dd($request);
        $fields = $request->validated();

        if ($request->hasFile('image')) {
            if ($ticket->image) {
                Storage::disk('public')->delete($ticket->image);
            }

            $fields['image'] =  Storage::disk('public')->put('images/tickets', $request->image);
        }else{
            $fields['image'] = $ticket->image;
        }
        // $request->user()->tickets()->create($fields);
        // Tickets::create($fields);
        $this->ticketService->update($ticket, $fields);

        return redirect()->route('tickets.index')->with('status','Ticket updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tickets $ticket)
    {
        if ($ticket->image) {
            Storage::disk('public')->delete($ticket->image);
        }

        $ticket->delete();
            // return redirect()->route('tickets.index')->with('status','Ticket deleted');
            return redirect()->route('tickets.index')->with('flash', [
            'status' => 'Ticket deleted successfully'
        ]);
    }
}
