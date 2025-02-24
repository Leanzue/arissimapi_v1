<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Send Attempt</title>
    <link rel="stylesheet" href="{{ asset('public/css/custom.css') }}">
</head>
<body>
<header>
    <nav>
    </nav>
</header>
<main>
    <h1>modifier SendAttempt</h1>
    <form method="POST" action="api/sendattempts/{{ $sendAttempt->id }}">
        @csrf
        @method('PUT')
        <div>
            <label for="response_data">Response Data:</label>
            <input type="text" name="response_data" id="response_data" value="{{ $sendAttempt->response_data }}" required>
        </div>
        <div>
            <label for="response_time">Response Time:</label>
            <input type="datetime-local" name="response_time" id="response_time" value="{{ $sendAttempt->response_time }}" required>
        </div>
        <button type="submit">Update</button>
    </form>
</main>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
