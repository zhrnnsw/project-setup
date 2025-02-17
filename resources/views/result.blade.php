<!DOCTYPE html>
<html>
<head>
    <title>Laravel Setup Result</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2>Setup Result</h2>
    <div class="alert alert-info">
        <ul>
            @foreach ($output as $line)
                <li>{{ $line }}</li>
            @endforeach
        </ul>
    </div>
    <a href="{{ route('setup.index') }}" class="btn btn-secondary">Back</a>
</body>
</html>
