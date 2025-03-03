<!-- resources/views/sim_responses/index.blade.php -->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index des Réponses SIM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('public/css/custom.css') }}">
</head>
<body>
<header class="bg-primary text-white text-center py-4">
    <h1>Index des Réponses SIM</h1>
</header>

<main class="container my-5">
    <!-- Affichage des messages de succès -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
@endif

<!-- Tableau des réponses SIM -->
    <table class="table table-striped table-hover">
        <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>ICCID</th>
            <th>Status</th>
            <th>Date de Changement de Status</th>
            <th>Client ID Request</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($simresponse as $simResponse)
            <tr>
                <td>{{ $simResponse->id }}</td>
                <td>{{ $simResponse->iccid }}</td>
                <td>{{ $simResponse->status }}</td>
                <td>{{ $simResponse->status_change_date }}</td>
                <td>{{ $simResponse->client_key_request }}</td>
                <td class="actions-container">
                    <!-- Bouton pour afficher les détails -->
                    <a href="{{ route('simresponses.show', $simResponse->id) }}" class="btn btn-info btn-sm">Afficher</a>
                    <!-- Bouton pour éditer -->
                    <a href="{{ route('simresponses.edit', $simResponse->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                    <!-- Formulaire pour supprimer -->
                    <form action="{{ route('simresponses.destroy', $simResponse->id) }}" method="POST" style="display: inline-block;" class="delete-form">
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

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
