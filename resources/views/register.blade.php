<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HelpDesk | Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body class="auth-body">
    <div class="auth-shell">
        <div class="auth-brand-panel">
            <div class="brand-badge">HelpDesk</div>
            <h1>Start your support journey.</h1>
            <p>Register now and submit tickets, track progress, and stay connected with your support team.</p>

            <div class="mini-feature-list">
                <div class="mini-feature">
                    <span>✓</span>
                    <div>
                        <strong>Simple signup</strong>
                        <small>Create your account quickly</small>
                    </div>
                </div>
                <div class="mini-feature">
                    <span>✓</span>
                    <div>
                        <strong>Track every issue</strong>
                        <small>See progress with live updates</small>
                    </div>
                </div>
                <div class="mini-feature">
                    <span>✓</span>
                    <div>
                        <strong>Helpful support</strong>
                        <small>Clear communication with team</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="auth-form-panel">
            <div class="auth-card">
                <div class="text-center mb-4">
                    <h2>Create account</h2>
                    <p class="text-muted mb-0">Join HelpDesk</p>
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

                <form method="POST" action="{{ route('register.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Register</button>
                </form>

                <div class="text-center mt-3">
                    <p class="mb-0">Already have an account? <a href="{{ route('login') }}">Login here</a></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
