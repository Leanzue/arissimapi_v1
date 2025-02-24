<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Send Result</title>
    <link rel="stylesheet" href="{{ asset('public/css/custom.css') }}">
</head>
<body>
<header>
    <nav>
    </nav>
</header>
<main>
    <h1>Edit SendResult</h1>
    <form method="POST" action="api/sendresults/{{ $sendResult->id }}">
        @csrf
        @method('PUT')
        <div>
            <label for="result_description">Result Description:</label>
            <input type="text" name="result_description" id="result_description" value="{{ $sendResult->result_description }}" required>
        </div>
        <div>
            <label for="nombre_tentative">Nombre Tentative:</label>
            <input type="text" name="nombre_tentative" id="nombre_tentative" value="{{ $sendResult->nombre_tentative }}" required>
        </div>
        <div>
            <label for="date_envoi">Date Envoi:</label>
            <input type="text" name="date_envoi" id="date_envoi" value="{{ $sendResult->date_envoi }}" required>
        </div>
        <div>
            <label for="error_code">Error Code:</label>
            <input type="text" name="error_code" id="error_code" value="{{ $sendResult->error_code }}" required>
        </div>
        <button type="submit">Update</button>
    </form>
</main>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
