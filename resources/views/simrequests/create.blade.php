<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Créer une Nouvelle Requête SIM</title>
    <link rel="stylesheet" href="{{ asset('public/css/custom.css') }}">
</head>
<body>
<header>
    <nav>
    </nav>
</header>
<main>
    <h1>Créer une Nouvelle Requête SIM</h1>
    <form action="{{ route('simrequests.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" class="form-control" id="description" name="description" required>
        </div>
        <div class="form-group">
            <label for="adresse_ip">Adresse IP</label>
            <input type="text" class="form-control" id="adresse_ip" name="adresse_ip" required>
        </div>
        <div class="form-group">
            <label for="date">Date</label>
            <input type="text" class="form-control" id="date" name="date" required>
        </div>
        <div class="form-group">
            <label for="code">Code</label>
            <input type="text" class="form-control" id="code" name="code" required>
        </div>
        <button type="submit" class="btn btn-primary">Créer</button>
    </form>
</main>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
