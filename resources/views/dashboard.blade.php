<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HelpDesk | Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body class="user-dashboard-body">
    <div class="user-shell">
        <aside class="sidebar">
            <div class="brand-box">
                <div class="brand-logo">H</div>
                <div>
                    <div class="brand-title">HelpDesk</div>
                    <small>User Portal</small>
                </div>
            </div>

            <nav class="sidebar-nav">
                <a class="nav-item active" href="{{ route('dashboard') }}">Overview</a>
                <a class="nav-item" href="{{ route('tickets') }}">My Tickets</a>
                <a class="nav-item" href="{{ route('tickets.create') }}">Create Ticket</a>
                <a class="nav-item" href="{{ route('dashboard') }}">My Account</a>
            </nav>

            <div class="sidebar-card">
                <small>Support Status</small>
                <strong>{{ $totalTickets ?? 0 }} Active</strong>
                <span>Tickets under review</span>
            </div>

            <form method="POST" action="{{ route('logout') }}" class="mt-auto">
                @csrf
                <button type="submit" class="btn btn-light w-100">Logout</button>
            </form>
        </aside>

        <main class="main-panel">
            <header class="topbar">
                <div>
                    <p class="top-label">Welcome back</p>
                    <h3>{{ Auth::user()->name }}</h3>
                </div>
                <div class="top-actions d-flex align-items-center gap-3">
                    <div class="text-end">
                        <small class="top-label d-block">Current Time</small>
                        <strong id="dashboard-clock">--:--:--</strong>
                    </div>
                    <a href="{{ route('tickets.create') }}" class="btn btn-primary">+ New Ticket</a>
                </div>
            </header>

            <div class="welcome-banner mb-4">
                <div>
                    <span class="badge badge-soft">Support Center</span>
                    <h2 class="mt-2 mb-1">How can we help you today?</h2>
                    <p class="mb-0">Track issues, monitor progress, and keep communication clear with your support team.</p>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div>
                            <h5 class="mb-1">Ticket Summary</h5>
                            <p class="text-muted mb-0">{{ $totalTickets ?? 0 }} tickets created</p>
                        </div>
                        <div class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill">
                            {{ $tickets->count() }} total
                        </div>
                    </div>

                    @if($tickets->isNotEmpty())
                        <div class="mt-3 d-flex flex-wrap gap-2">
                            @foreach($tickets as $ticket)
                                <span class="badge bg-light text-dark border">{{ $ticket->subject }}</span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0 mt-3">No tickets created yet.</p>
                    @endif
                </div>
            </div>

            <div class="legend-box mb-4">
                <div class="legend-item"><span class="legend-dot status-open"></span> Open = New request</div>
                <div class="legend-item"><span class="legend-dot status-in-progress"></span> In Progress = Team working</div>
                <div class="legend-item"><span class="legend-dot status-resolved"></span> Resolved = Fixed and waiting</div>
                <div class="legend-item"><span class="legend-dot status-closed"></span> Closed = Finished</div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card stat-card border-0 shadow-sm stat-total text-white">
                        <div class="card-body">
                            <span class="stat-label">Total</span>
                            <h2>{{ $totalTickets ?? 0 }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card border-0 shadow-sm stat-open text-dark">
                        <div class="card-body">
                            <span class="stat-label">Open</span>
                            <h2>{{ $openTickets ?? 0 }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card border-0 shadow-sm stat-progress text-dark">
                        <div class="card-body">
                            <span class="stat-label">In Progress</span>
                            <h2>{{ $inProgressTickets ?? 0 }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card border-0 shadow-sm stat-resolved text-white">
                        <div class="card-body">
                            <span class="stat-label">Resolved</span>
                            <h2>{{ $resolvedTickets ?? 0 }}</h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Tickets</h5>
                    <a href="{{ route('tickets.create') }}" class="btn btn-primary btn-sm">New Ticket</a>
                </div>
                <div class="card-body">
                    @if($tickets->isEmpty())
                        <p class="text-muted mb-0">No tickets available yet.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table align-middle table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Subject</th>
                                        <th>Category</th>
                                        <th>Priority</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tickets as $ticket)
                                        <tr>
                                            <td>{{ $ticket->id }}</td>
                                            <td>{{ $ticket->subject }}</td>
                                            <td>{{ $ticket->category ? $ticket->category->name : '-' }}</td>
                                            <td>
                                                <span class="badge priority-{{ strtolower($ticket->priority) }}">{{ $ticket->priority }}</span>
                                            </td>
                                            <td>
                                                <span class="badge status-{{ strtolower(str_replace(' ', '-', $ticket->status)) }}">{{ $ticket->status }}</span>
                                            </td>
                                            <td>{{ $ticket->created_at ? $ticket->created_at->format('d M Y, h:i A') : 'N/A' }}</td>
                                            <td>
                                                <a href="{{ route('ticket.details', $ticket->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>

    @if(session('success'))
        <div class="modal fade" id="successTicketModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-body text-center p-4">
                        <div class="success-icon mb-3">✓</div>
                        <h4 class="mb-2">Success!</h4>
                        <p class="mb-0">{{ session('success') }}</p>
                    </div>
                    <div class="modal-footer justify-content-center border-0 pb-4">
                        <button type="button" class="btn btn-primary px-4" data-bs-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var successModal = new bootstrap.Modal(document.getElementById('successTicketModal'));
                successModal.show();
            });
        </script>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
