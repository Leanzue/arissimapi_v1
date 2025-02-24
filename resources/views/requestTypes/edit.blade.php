<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Request Type</title>
    <link rel="stylesheet" href="{{ asset('public/css/custom.css') }}">
</head>
<body>
<header>
    <nav>
    </nav>
</header>
<main>
    <h1>Edit RequestType</h1>
    <form method="POST" action="api/requestTypes/{{ $requestType->id }}">
        @csrf
        @method('PUT')
        <div>
            <label for="action">Action:</label>
            <input type="text" name="action" id="action" value="{{ $requestType->action }}" required>
        </div>
        <div>
            <label for="libellé">Libellé:</label>
            <input type="text" name="libellé" id="libellé" value="{{ $requestType->libellé }}" required>
        </div>
        <button type="submit">Update</button>
    </form>
</main>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
