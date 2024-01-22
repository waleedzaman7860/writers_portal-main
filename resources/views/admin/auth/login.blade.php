<head>
    <meta charset="UTF-8">
    <title>Log In</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            /* background: url(http://private.indocyber.pro/test/image/background.png) fixed 50% no-repeat white; */
            font-family: Poppin;
        }

        h2 {
            color: #336895;
        }

        form {
            width: 300px;
            height: 300px;
            margin: 200px auto;
            background: white;
            border-radius: 3px;
            box-shadow: 0 0 10px rgba(0, 0, 0, .4);
            text-align: center;
            padding-top: 1px;
        }

        .warning{
            font-size: 13px;
            font-weight: bold;
            color: red;
            text-align: left;
        }
    </style>

</head>

<body>
    <div class="card p-3">
        <form method="POST" action="{{ route('admin.check') }}">
            @csrf
            <div class="card-body">
                <h2 class="card-title mt-2 mb-4 fw-bold">Admin Login</h2>
                <div class="mb-3">
                    <input type="text" name="email" class="form-control" placeholder="Admin email"
                        value="{{ old('email') }}" />
                    @error('email')
                        <div class="warning">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password"
                        value="{{ old('password') }}" />
                    @error('password')
                        <div class="warning">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary rounded-1 fw-bold">Login</button>
            </div>
        </form>
    </div>
</body>
