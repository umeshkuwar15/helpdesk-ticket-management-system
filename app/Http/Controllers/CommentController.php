<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Add a comment or reply to a ticket.
     */
    public function store(Request $request, Ticket $ticket)
    {
        if (Auth::id() !== $ticket->user_id && Auth::user()->role !== 'admin') {
            abort(403, 'You are not allowed to comment on this ticket.');
        }

        $validated = $request->validate([
            'comment' => 'required|string|max:2000',
        ]);

        Comment::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'comment' => $validated['comment'],
        ]);

        return redirect()->route('ticket.details', $ticket->id)->with('success', 'Comment added successfully.');
    }
}
