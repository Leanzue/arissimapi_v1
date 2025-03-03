<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Créer une Nouvelle Requête SIM</title>
    <link rel="stylesheet" href="{{ asset('public/css/custom.css') }}">
</head>
<body>
<header class="bg-primary text-white text-center py-4">
    <h1>Créer une Nouvelle Requête SIM</h1>
</header>
<main class="container my-5">
    <form action="{{ route('simrequests.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="code">Code</label>
            <input type="text" class="form-control" id="code" name="code" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" class="form-control" id="description" name="description" required>
        </div>
        <div class="form-group">
            <label for="client_ip_address">Client IP Adresse</label>
            <input type="text" class="form-control" id="client_ip_address" name="client_ip_address" required>
        </div>
        <div class="form-group">
            <label for="url_response">URL Réponse</label>
            <input type="text" class="form-control" id="url_response" name="url_response" required>
        </div>
        <div class="form-group">
            <label for="file_prefix">File Prefix</label>
            <input type="text" class="form-control" id="file_prefix" name="file_prefix" required>
        </div>
        <div class="form-group">
            <label for="client_id_request">Client ID Request</label>
            <input type="text" class="form-control" id="client_id_request" name="client_id_request" required>
        </div>
        <div class="form-group">
            <label for="file_extension">File Extension</label>
            <input type="text" class="form-control" id="file_extension" name="file_extension" required>
        </div>
        <button type="submit" class="btn btn-primary">Créer</button>
    </form>
</main>
<script src="{{ asset('js/app.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
