<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * Show user dashboard with ticket counts.
     */
    public function dashboard()
    {
        $tickets = Ticket::where('user_id', Auth::id())->latest()->get();

        return view('dashboard', [
            'tickets' => $tickets,
            'totalTickets' => $tickets->count(),
            'openTickets' => $tickets->where('status', 'Open')->count(),
            'inProgressTickets' => $tickets->where('status', 'In Progress')->count(),
            'resolvedTickets' => $tickets->where('status', 'Resolved')->count(),
        ]);
    }

    /**
     * Show form to create a new ticket.
     */
    public function create()
    {
        $categories = Category::all();

        return view('create-ticket', compact('categories'));
    }

    /**
     * Store a ticket in the database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:Low,Medium,High,Urgent',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'Open';

        Ticket::create($validated);

        return redirect()->route('dashboard')->with('success', 'Ticket has been successfully created, ' . Auth::user()->name . '!');
    }

    /**
     * Display all tickets for the user.
     */
    public function index()
    {
        $tickets = Ticket::with(['category', 'comments.user'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('tickets', compact('tickets'));
    }

    /**
     * Display the details of a given ticket.
     */
    public function show(Ticket $ticket)
    {
        if (Auth::id() !== $ticket->user_id && Auth::user()->role !== 'admin') {
            abort(403, 'You are not allowed to access this ticket.');
        }

        $ticket->load(['category', 'comments.user']);

        return view('ticket-details', compact('ticket'));
    }
}
