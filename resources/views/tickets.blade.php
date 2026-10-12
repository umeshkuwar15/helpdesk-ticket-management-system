<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HelpDesk | Tickets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">HelpDesk</a>
            <div class="ms-auto d-flex align-items-center gap-2">
                <a href="{{ route('dashboard') }}" class="btn btn-outline-light btn-sm">Dashboard</a>
                <a href="{{ route('tickets.create') }}" class="btn btn-light btn-sm">Create Ticket</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-danger btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <div class="card shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">{{ Auth::user()->role === 'admin' ? 'All Tickets' : 'My Tickets' }}</h4>
                @if(Auth::user()->role === 'user')
                    <a href="{{ route('tickets.create') }}" class="btn btn-primary btn-sm">New Ticket</a>
                @endif
            </div>
            <div class="card-body">
                @if($tickets->isEmpty())
                    <p class="text-muted mb-0">No tickets found.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Subject</th>
                                    <th>Category</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th>Submitted By</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tickets as $ticket)
                                    <tr>
                                        <td>{{ $ticket->id }}</td>
                                        <td>{{ $ticket->subject }}</td>
                                        <td>{{ $ticket->category->name ?? '-' }}</td>
                                        <td><span class="badge priority-{{ strtolower($ticket->priority) }}">{{ $ticket->priority }}</span></td>
                                        <td><span class="badge status-{{ strtolower(str_replace(' ', '-', $ticket->status)) }}">{{ $ticket->status }}</span></td>
                                        <td>{{ $ticket->user->name ?? 'Unknown' }}</td>
                                        <td>
                                            <a href="{{ route('ticket.details', $ticket->id) }}" class="btn btn-sm btn-outline-primary">Open</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
