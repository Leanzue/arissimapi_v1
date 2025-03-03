<!-- resources/views/sim_responses/create.blade.php -->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer une Nouvelle Réponse SIM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('public/css/custom.css') }}">
</head>
<body>
<header class="bg-primary text-white text-center py-4">
    <h1>Créer une Nouvelle Réponse SIM</h1>
</header>
<main class="container my-5">
    <form action="{{ route('simresponses.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="iccid">ICCID</label>
            <input type="text" class="form-control" id="iccid" name="iccid" required>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <input type="text" class="form-control" id="status" name="status" required>
        </div>
        <div class="form-group">
            <label for="status_change_date">Date de Changement de Status</label>
            <input type="text" class="form-control" id="status_change_date" name="status_change_date" required>
        </div>
        <div class="form-group">
            <label for="client_key_request">Client ID Request</label>
            <input type="text" class="form-control" id="client_key_request" name="client_key_request" required>
        </div>
        <button type="submit" class="btn btn-primary">Créer</button>
    </form>
</main>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
