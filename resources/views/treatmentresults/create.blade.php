<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un nouveau résultat</title>
    <!-- Ajout de Bootstrap pour un style moderne -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Lien vers votre fichier CSS personnalisé -->
    <link rel="stylesheet" href="{{ asset('public/css/custom.css') }}">
</head>
<body>
<header class="bg-primary text-white text-center py-4">
    <h1>Créer un nouveau résultat</h1>
</header>

<main class="container my-5">
    <form action="{{ route('treatmentresults.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="resultat" class="form-label">Date de tentative</label>
            <input type="date" class="form-control" id="resultat" name="resultat" required>
        </div>
        <div class="mb-3">
            <label for="libelle" class="form-label">Libellé</label>
            <input type="text" class="form-control" id="libelle" name="libelle" required>
        </div>
        <div class="mb-3">
            <label for="details" class="form-label">Détails</label>
            <input type="text" class="form-control" id="details" name="details" required>
        </div>
        <div class="mb-3">
            <label for="posi" class="form-label">Commentaire</label>
            <textarea class="form-control" id="posi" name="posi" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Créer</button>
    </form>
</main>

<!-- Ajout de Bootstrap JS et Popper.js pour les fonctionnalités interactives -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<!-- Lien vers votre fichier JS personnalisé -->
<script src="{{ asset('public/js/app.js') }}"></script>
</body>
</html>
