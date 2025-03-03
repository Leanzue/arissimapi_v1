<!-- resources/views/treatments/create.blade.php -->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Nouveau Traitement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('public/css/custom.css') }}">
</head>
<body>
<header class="bg-primary text-white text-center py-4">
    <h1>Créer un Nouveau Traitement</h1>
</header>
<main class="container my-5">
    <form action="{{ route('treatments.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="service_class">Classe Service</label>
            <input type="text" class="form-control" id="service_class" name="service_class" required>
        </div>
        <div class="form-group">
            <label for="libelle_service">Libellé Service</label>
            <input type="text" class="form-control" id="libelle_service" name="libelle_service" required>
        </div>
        <div class="form-group">
            <label for="date_debut">Date de Début</label>
            <input type="text" class="form-control" id="date_debut" name="date_debut" required>
        </div>
        <div class="form-group">
            <label for="date_fin">Date de Fin</label>
            <input type="text" class="form-control" id="date_fin" name="date_fin">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" class="form-control" id="description" name="description">
        </div>
        <div class="form-group">
            <label for="treatment_attempt_id">Tentative ID</label>
            <input type="text" class="form-control" id="treatment_attempt_id" name="treatment_attempt_id">
        </div>
        <div class="form-group">
            <label for="treatment_status_id">Status ID</label>
            <input type="text" class="form-control" id="treatment_status_id" name="treatment_status_id">
        </div>
        <button type="submit" class="btn btn-primary">Créer</button>
    </form>
</main>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
