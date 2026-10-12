<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HelpDesk | Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body class="auth-body">
    <div class="auth-shell">
        <div class="auth-brand-panel">
            <div class="brand-badge">HelpDesk</div>
            <h1>Smart support for every user.</h1>
            <p>Track issues, get quick replies, and manage support requests in one clean workspace.</p>

            <div class="mini-feature-list">
                <div class="mini-feature">
                    <span>✓</span>
                    <div>
                        <strong>Fast Ticketing</strong>
                        <small>Submit issues in seconds</small>
                    </div>
                </div>
                <div class="mini-feature">
                    <span>✓</span>
                    <div>
                        <strong>Real-time Updates</strong>
                        <small>See status changes quickly</small>
                    </div>
                </div>
                <div class="mini-feature">
                    <span>✓</span>
                    <div>
                        <strong>Support Team</strong>
                        <small>Replies from admin desk</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="auth-form-panel">
            <div class="auth-card">
                <div class="text-center mb-4">
                    <h2>Welcome back</h2>
                    <p class="text-muted mb-0">Login to your account</p>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('login.authenticate') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>

                <div class="text-center mt-3">
                    <p class="mb-0">Need an account? <a href="{{ route('register') }}">Create one</a></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
