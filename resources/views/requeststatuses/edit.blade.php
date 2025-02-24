<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Statut de Tentative</title>
    <link rel="stylesheet" href="{{ asset('public/css/custom.css') }}">
</head>
<body>
<header>
    <nav>
    </nav>
</header>
<main>
    <h1>Modifier une requete</h1>
    <form method="POST" action="api/requeststatuses/{{ $requestStatus->id }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="priority">Priorité</label>
            <input type="text" class="form-control" id="priority" name="priority" value="{{ $requestStatus->priority }}" required>
        </div>
        <div class="form-group">
            <label for="libellé">Libellé</label>
            <input type="text" class="form-control" id="libellé" name="libellé" value="{{ $requestStatus->libellé }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Modifier</button>
    </form>
</main>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
