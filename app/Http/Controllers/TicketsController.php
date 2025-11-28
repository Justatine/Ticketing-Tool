<?php

namespace App\Http\Controllers;

use App\Http\Middleware\NotAdmin;
use App\Models\Tickets;
use App\Models\User;
use App\Http\Requests\StoreTicketsRequest;
use App\Http\Requests\UpdateTicketsRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TicketsController extends Controller implements HasMiddleware
{
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
        $tickets = Tickets::with(['assignee', 'reporter'])
                    ->filter(request(['search', 'assignee_id']))
                    ->latest()
                    ->paginate(5)
                    ->withQueryString();

        return Inertia::render('Tickets/Index', [
            'tickets' => $tickets,
            'searchTerm' => $request->search
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $assignees = User::all();
        return Inertia::render('Tickets/Create',[
            'assignees' => $assignees
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $fields = $request->validate([
            'title'=>['required','max:255'],
            'description' => ['required', 'string'],
            'status'=>['required','max:255'],
            'priority'=>['required','max:255'],
            'image'=>['nullable','file','max:3072','mimes:jpeg,jpg,png'],
            'assignee_id' => ['required', 'integer', 'exists:users,id'],
            'reporter_id' => ['required', 'integer', 'exists:users,id'],
        ]);

        if ($request->hasFile('image')) {
            $fields['image'] =  Storage::disk('public')->put('images/tickets', $request->image);
        }
        // $request->user()->tickets()->create($fields);
        Tickets::create($fields);

        return redirect()->route('tickets.index')->with('status','Ticket created');
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
        $assignees = User::all();
        return Inertia::render('Tickets/Edit',[
            'ticket' => $ticket,
            'assignees' => $assignees
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tickets $ticket)
    {
        // dd($request);
        $fields = $request->validate([
            'title'=>['required','max:255'],
            'description' => ['required', 'string'],
            'status'=>['required','max:255'],
            'priority'=>['required','max:255'],
            'image'=>['nullable','file','max:3072','mimes:jpeg,jpg,png'],
            'assignee_id' => ['required', 'integer', 'exists:users,id'],
            'reporter_id' => ['required', 'integer', 'exists:users,id'],
        ]);

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
        $ticket->update($fields);

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
