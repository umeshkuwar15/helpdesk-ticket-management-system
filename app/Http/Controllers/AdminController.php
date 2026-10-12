<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Show admin dashboard.
     */
    public function dashboard()
    {
        $tickets = Ticket::with(['user', 'category'])->latest()->get();

        return view('dashboard', [
            'tickets' => $tickets,
            'totalTickets' => $tickets->count(),
            'openTickets' => $tickets->where('status', 'Open')->count(),
            'inProgressTickets' => $tickets->where('status', 'In Progress')->count(),
            'resolvedTickets' => $tickets->where('status', 'Resolved')->count(),
            'isAdmin' => true,
        ]);
    }

    /**
     * Display all tickets to the admin.
     */
    public function tickets()
    {
        $tickets = Ticket::with(['user', 'category', 'comments.user'])->latest()->get();

        return view('tickets', compact('tickets'));
    }

    /**
     * Update a ticket status or assignment.
     */
    public function updateStatus(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'status' => 'required|in:Open,In Progress,Resolved,Closed',
        ]);

        $ticket->update($validated);

        return redirect()->back()->with('success', 'Ticket status updated successfully.');
    }

    /**
     * Display category management page.
     */
    public function categories()
    {
        $categories = Category::all();

        return view('categories', compact('categories'));
    }

    /**
     * Store a new category.
     */
    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create($validated);

        return redirect()->back()->with('success', 'Category created successfully.');
    }

    /**
     * Check admin access.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (Auth::check() && Auth::user()->role !== 'admin') {
                abort(403, 'Access denied. Admin only.');
            }

            return $next($request);
        });
    }
}
