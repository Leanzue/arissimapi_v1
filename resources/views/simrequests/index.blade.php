<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request SIM</title>
    <!-- Ajout de Bootstrap pour un style moderne -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Lien vers votre fichier CSS personnalisé -->
    <link rel="stylesheet" href="{{ asset('public/css/custom.css') }}">
</head>
<body>
<header class="bg-primary text-white text-center py-4">
    <h1>Request SIM</h1>
</header>

<main class="container my-5">
    <!-- Affichage des messages de succès -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
@endif

<!-- Bouton pour créer une nouvelle requête SIM -->
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('simrequests.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Nouveau
        </a>
    </div>

    <!-- Tableau des requêtes SIM -->
    <table class="table table-striped table-hover">
        <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Code</th>
            <th>Description</th>
            <th>Client IP Adresse</th>
            <th>Url Réponse</th>
            <th>File Prefix</th>
            <th>Client ID Request</th>
            <th>File Extension</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($simrequests as $simRequest)
            <tr>
                <td>{{ $simRequest->id }}</td>
                <td>{{ $simRequest->code }}</td>
                <td>{{ $simRequest->description }}</td>
                <td>{{ $simRequest->client_ip_adresse }}</td>
                <td>{{ $simRequest->url_reponse }}</td>
                <td>{{ $simRequest->file_prefix }}</td>
                <td>{{ $simRequest->client_key_request }}</td>
                <td>{{ $simRequest->file_extension }}</td>
                <td class="actions-container">
                    <!-- Bouton pour afficher les détails -->
                    <a href="{{ route('simrequests.show', $simRequest->id) }}" class="btn btn-info btn-sm">Afficher</a>
                    <!-- Bouton pour éditer -->
                    <a href="{{ route('simrequests.edit', $simRequest->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                    <!-- Formulaire pour supprimer -->
                    <form action="{{ route('simrequests.destroy', $simRequest->id) }}" method="POST" style="display: inline-block;" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet élément ?');">Supprimer</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</main>

<!-- Ajout de Bootstrap JS et Popper.js pour les fonctionnalités interactives -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Lien vers votre fichier JS personnalisé -->
<script src="{{ asset('public/js/app.js') }}"></script>
</body>
</html>
