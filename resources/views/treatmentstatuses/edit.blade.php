<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Statut</title>
    <link rel="stylesheet" href="{{ asset('public/css/custom.css') }}">
</head>
<body>
<header>
    <nav>
    </nav>
</header>
<main>
    <h1>Modifier le Statut</h1>
    <form method="POST" action="{{ url('api/attemptstatuses/'.$attemptstatuses->id) }}">
        @csrf
        @method('PUT')
        <div>
            <label for="nombre_essais">Nombre d'Essais :</label>
            <input type="number" name="nombre_essais" id="nombre_essais" value="{{ $attemptstatuses->nombre_essais }}" required>
        </div>
        <div>
            <label for="error_code">Code d'Erreur :</label>
            <input type="number" name="error_code" id="error_code" value="{{ $attemptstatuses->error_code }}" required>
        </div>
        <div>
            <label for="details">Détails :</label>
            <input type="text" name="details" id="details" value="{{ $attemptstatuses->details }}" required>
        </div>
        <div>
            <label for="status">Statut :</label>
            <input type="text" name="status" id="status" value="{{ $attemptstatuses->status }}" required>
        </div>
        <div>
            <label for="comment">Commentaire :</label>
            <input type="text" name="comment" id="comment" value="{{ $attemptstatuses->comment }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Mettre à Jour</button>
    </form>
</main>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
