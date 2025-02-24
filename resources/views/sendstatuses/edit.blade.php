<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Modifier un Statut d'Envoi</title>
    <link rel="stylesheet" href="{{ asset('public/css/custom.css') }}">
</head>
<body>
<header>
    <nav>
    </nav>
</header>
<main>
    <h1>Modifier un Statut d'Envoi</h1>
    <form method="POST"action="api/sendStatuses{{$sendStatus->id}}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="priority">Priorité</label>
            <input type="text" class="form-control" id="priority" name="priority" value="{{ $sendStatus->priority }}" required>
        </div>
        <div class="form-group">
            <label for="libellé">Libellé</label>
            <input type="text" class="form-control" id="libellé" name="libellé" value="{{ $sendStatus->libellé }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Modifier</button>
    </form>
</main>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
