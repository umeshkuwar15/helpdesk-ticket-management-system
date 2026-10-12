<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HelpDesk | Ticket Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">HelpDesk</a>
            <div class="ms-auto d-flex align-items-center gap-2">
                <a href="{{ route('dashboard') }}" class="btn btn-outline-light btn-sm">Dashboard</a>
                <a href="{{ route('tickets') }}" class="btn btn-outline-light btn-sm">Tickets</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-danger btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                <h4 class="mb-0">Ticket #{{ $ticket->id }} - {{ $ticket->subject }}</h4>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <span class="badge priority-{{ strtolower($ticket->priority) }} me-2">{{ $ticket->priority }}</span>
                    <span class="badge status-{{ strtolower(str_replace(' ', '-', $ticket->status)) }}">{{ $ticket->status }}</span>
                </div>
            </div>
            <div class="card-body">
                <p><strong>Category:</strong> {{ $ticket->category->name ?? 'N/A' }}</p>
                <p><strong>Submitted by:</strong> {{ $ticket->user->name }}</p>
                <p><strong>Ticket Created:</strong> {{ $ticket->created_at ? $ticket->created_at->format('d M Y, h:i A') : 'N/A' }}</p>
                <p><strong>Current Time:</strong> <span id="ticket-current-time">--:--:--</span></p>
                <div class="mt-3 p-3 rounded bg-light border">
                    {{ $ticket->description }}
                </div>
            </div>
        </div>

        @if(Auth::user()->role === 'admin')
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Update Ticket Status</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.ticket.status', $ticket->id) }}">
                        @csrf
                        @method('PATCH')
                        <div class="row align-items-end">
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    @foreach(['Open', 'In Progress', 'Resolved', 'Closed'] as $status)
                                        <option value="{{ $status }}" {{ $ticket->status === $status ? 'selected' : '' }}>{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">Update Status</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-header">
                <h5 class="mb-0">Comments</h5>
            </div>
            <div class="card-body">
                @forelse($ticket->comments as $comment)
                    <div class="border rounded p-3 mb-3">
                        <div class="mb-2">
                            <strong>{{ $comment->user->name }}</strong>
                        </div>
                        <p class="mb-0">{{ $comment->comment }}</p>
                    </div>
                @empty
                    <p class="text-muted mb-0">No comments yet. Start the conversation.</p>
                @endforelse

                <form method="POST" action="{{ route('comments.store', $ticket->id) }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Comment</label>
                        <textarea name="comment" class="form-control" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Comment</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const ticketCurrentTime = document.getElementById('ticket-current-time');
        function updateTicketCurrentTime() {
            if (ticketCurrentTime) {
                const now = new Date();
                ticketCurrentTime.textContent = now.toLocaleString('en-GB', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                });
            }
        }
        updateTicketCurrentTime();
        setInterval(updateTicketCurrentTime, 1000);
    </script>
</body>
</html>
