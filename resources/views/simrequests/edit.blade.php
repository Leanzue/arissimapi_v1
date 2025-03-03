<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une Requête SIM</title>
    <!-- Ajout de Bootstrap pour un style moderne -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Lien vers votre fichier CSS personnalisé -->
    <link rel="stylesheet" href="{{ asset('public/css/custom.css') }}">
</head>
<body>
<header class="bg-primary text-white text-center py-4">
    <h1>Modifier une Requête SIM</h1>
</header>

<main class="container my-5">
    <form method="POST" action="api/simrequests/{{ $simRequest->id }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="code" class="form-label">Code</label>
            <input type="text" class="form-control" id="code" name="code" value="{{ $simRequest->code }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <input type="text" class="form-control" id="description" name="description" value="{{ $simRequest->description }}" required>
        </div>
        <div class="mb-3">
            <label for="client_IP_Adresse" class="form-label">Client IP Adresse</label>
            <input type="number" class="form-control" id="client_IP_Adresse" name="client_IP_Adresse" value="{{ $simRequest->client_IP_Adresse }}" required>
        </div>
        <div class="mb-3">
            <label for="Url_reponse" class="form-label">URL Réponse</label>
            <input type="text" class="form-control" id="Url_reponse" name="Url_reponse" value="{{ $simRequest->Url_reponse }}" required>
        </div>
        <div class="mb-3">
            <label for="file_prefix" class="form-label">File Prefix</label>
            <input type="text" class="form-control" id="file_prefix" name="file_prefix" value="{{ $simRequest->file_prefix }}" required>
        </div>
        <div class="mb-3">
            <label for="client_key_request" class="form-label">Client ID Request</label>
            <input type="text" class="form-control" id="client_key_request" name="client_key_request" value="{{ $simRequest->client_key_request }}" required>
        </div>
        <div class="mb-3">
            <label for="file_extension" class="form-label">File Extension</label>
            <input type="text" class="form-control" id="file_extension" name="file_extension" value="{{ $simRequest->file_extension }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Modifier</button>
    </form>
</main>

<!-- Ajout de Bootstrap JS et Popper.js pour les fonctionnalités interactives -->
<script src="https
