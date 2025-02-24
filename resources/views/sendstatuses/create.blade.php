<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Créer un Nouveau Statut d'Envoi</title>
    <link rel="stylesheet" href="{{ asset('public/css/custom.css') }}">
</head>
<body>
<header>
    <nav>
    </nav>
</header>
<main>
    <h1>Créer un Nouveau Statut d'Envoi</h1>
    <form action="{{ route('sendstatuses.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="priority">Priorité</label>
            <input type="text" class="form-control" id="priority" name="priority" required>
        </div>
        <div class="form-group">
            <label for="libellé">Libellé</label>
            <input type="text" class="form-control" id="libellé" name="libellé" required>
        </div>
        <button type="submit" class="btn btn-primary">Créer</button>
    </form>
</main>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
