<!DOCTYPE html>
<html>
<head>
    <title>Laravel Project Setup</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="container mt-5">
    <h2>Laravel Project Setup</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>  
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>    
    @endif

    <form id="setup-form" action="{{ route('setup.run')}}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="db-host" class="form-label">Database Host</label>
            <input type="text" class="form-control" id="db_host" name="db-host" value="{{ old('db_host', env('DB_HOST', 'localhost') )}}" >
        </div>
        <div class="mb-3">
            <label for="db_port" class="form-label">Database Port</label>
            <input type="text" class="form-control" id="db_port" name="db_port" value="{{ old('db_port', env('DB_PORT', '3306') )}}" required>
        </div>
        <div class="mb-3">
            <label for="db_database" class="form-label">Database Name</label>
            <input type="text" class="form-control" id="db_database" name="db_database" value="{{ old('db_database', env('DB_DATABASE', '') )}}" required>
        </div>
        <div class="mb-3">
            <label for="db_username" class="form-label">Database Username</label>
            <input type="text" class="form-control" id="db_username" name="db_username" value="{{ old('db_username', env('DB_USERNAME', 'root')) }}" required>
        </div>
        <div class="mb-3">
            <label for="db_password" class="form-label">Database Password</label>
            <input type="password" class="form-control" id="db_password" name="db_password" value="{{ old('db_password', env('DB_PASSWORD', '') )}}">
        </div>
        <button type="submit" class="btn btn-primary">Run Setup</button>
    </form>

    <div id="loader" class="mt-3 text-primary d-none">Processing setup...</div>
    <div id="setup-output" class="mt-3 d-none">
        <pre id="output-box" class="p-3 bg-light border rounded"></pre>
    </div>
    <div id="setup-status" class="alert mt-3 d-none"></div>

    <script>
        $(document).ready(function () {
            $('#setup-form').submit(function (event) {
                event.preventDefault();

                $('#loader').removeClass('d-none'); 
                $('#setup-output, #setup-status').addClass('d-none');

                $.ajax({
                    url: "{{ route('setup.run') }}",
                    method: "POST",
                    data: $('#setup-form').serialize(),
                    success: function (response) {
                        $('#loader').addClass('d-none');

                        // Menampilkan log hasil setup di output box
                        $('#output-box').html(response.output);
                        $('#setup-output').removeClass('d-none');

                        // Menampilkan status di alert box
                        let statusClass = response.status === "success" ? "alert-success" : "alert-danger";
                        let statusText = `<strong>Status:</strong> ${response.status.toUpperCase()}<br><strong>Message:</strong> ${response.message}`;

                        $('#setup-status').removeClass('d-none alert-success alert-danger').addClass(`alert ${statusClass}`).html(statusText);
                    },
                    error: function () {
                        $('#loader').addClass('d-none');
                        $('#setup-status').removeClass('d-none alert-success').addClass('alert alert-danger').html("<strong>Status:</strong> ERROR <br> An error occurred while running setup.");
                    }
                });
            });
        });
    </script>
</body>
</html>
