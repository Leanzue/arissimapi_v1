<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Request Type</title>
    <link rel="stylesheet" href="{{ asset('public/css/custom.css') }}">
</head>
<body>
<header>
    <nav>
    </nav>
</header>
<main>
    <h1>Create New RequestType</h1>
    <form method="POST" action="{{ route('requestTypes.store') }}">
        @csrf
        <div>
            <label for="action">Action:</label>
            <input type="text" name="action" id="action" required>
        </div>
        <div>
            <label for="libellé">Libellé:</label>
            <input type="text" name="libellé" id="libellé" required>
        </div>
        <button type="submit">Créer</button>
    </form>

    </form>
</main>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
