<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer une Nouvelle SIM</title>
    <!-- Ajout de Bootstrap pour un style moderne -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Lien vers votre fichier CSS personnalisé -->
    <link rel="stylesheet" href="{{ asset('public/css/custom.css') }}">
</head>
<body>
<header class="bg-primary text-white text-center py-4">
    <h1>Créer une Nouvelle SIM</h1>
</header>

<main class="container my-5">
    <form action="{{ route('sims.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="iccid" class="form-label">ICCID</label>
            <input type="text" class="form-control" id="iccid" name="iccid" required>
        </div>
        <div class="mb-3">
            <label for="imsi" class="form-label">IMSI</label>
            <input type="text" class="form-control" id="imsi" name="imsi" required>
        </div>
        <div class="mb-3">
            <label for="puk" class="form-label">PUK</label>
            <input type="text" class="form-control" id="puk" name="puk" required>
        </div>
        <div class="mb-3">
            <label for="pin" class="form-label">PIN</label>
            <input type="text" class="form-control" id="pin" name="pin" required>
        </div>
        <button type="submit" class="btn btn-primary">Créer</button>
    </form>
</main>

<!-- Ajout de Bootstrap JS et Popper.js pour les fonctionnalités interactives -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Lien vers votre fichier JS personnalisé -->
<script src="{{ asset('public/js/app.js') }}"></script>
</body>
</html>
