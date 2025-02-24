<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Send Attempt Result</title>
    <link rel="stylesheet" href="{{ asset('public/css/custom.css') }}">
</head>
<body>
<header>
    <nav>
    </nav>
</header>
<main>
    <h1>Edit SendAttemptResult</h1>
    <form method="POST" action="api/SendAttemptResults/{{ $sendAttemptResult->id }}">
        @csrf
        @method('PUT')
        <div>
            <label for="date_of_sending_results">Date of Sending Results:</label>
            <input type="text" name="date_of_sending_results" id="date_of_sending_results" value="{{ $sendAttemptResult->date_of_sending_results }}" required>
        </div>
        <div>
            <label for="details">Details:</label>
            <input type="text" name="details" id="details" value="{{ $sendAttemptResult->details }}" required>
        </div>
        <div>
            <label for="error_code">Error Code:</label>
            <input type="text" name="error_code" id="error_code" value="{{ $sendAttemptResult->error_code }}" required>
        </div>
        <div>
            <label for="nombre_de_tentative">Nombre de Tentative:</label>
            <input type="text" name="nombre_de_tentative" id="nombre_de_tentative" value="{{ $sendAttemptResult->nombre_de_tentative }}" required>
        </div>
        <button type="submit">Update</button>
    </form>
</main>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
