<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Statut de Demande</title>
    <link rel="stylesheet" href="{{ asset('public/css/custom.css') }}">
</head>
<body>
<header>
    <nav>
    </nav>
</header>
<main>
    <h1>Créer un Nouveau Statut de Demande</h1>
    <form action="{{ route('requeststatuses.store') }}" method="POST">
        @csrf
        <div>
            <label for="priority">Priorité :</label>
            <input type="text" name="priority" id="priority" value="{{ old('priority') }}" required>
        </div>
        <div>
            <label for="libellé">Libellé :</label>
            <input type="text" name="libellé" id="libellé" value="{{ old('libellé') }}" required>
        </div>
        <button type="submit">Créer</button>
    </form>
</main>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
