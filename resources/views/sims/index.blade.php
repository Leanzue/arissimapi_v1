<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMS</title>
    <!-- Ajout de Bootstrap pour un style moderne -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Lien vers votre fichier CSS personnalisé -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body>
<header class="bg-primary text-white text-center py-4">
    <h1>SIMS</h1>
</header>

<main class="container my-5">
    <!-- Affichage des messages de succès -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
@endif

<!-- Bouton pour créer une nouvelle SIM -->
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('sims.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Nouveau
        </a>
    </div>

    <!-- Tableau des SIMs -->
    <table class="table table-striped table-hover">
        <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>ICCID</th>
            <th>IMSI</th>
            <th>PUK</th>
            <th>PIN</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($sims as $sim)
            <tr>
                <td>{{ $sim->id }}</td>
                <td>{{ $sim->iccid }}</td>
                <td>{{ $sim->imsi }}</td>
                <td>{{ $sim->puk }}</td>
                <td>{{ $sim->pin }}</td>
                <td class="actions-container">
                    <!-- Bouton pour afficher les détails -->
                    <a href="{{ route('sims.show', $sim->id) }}" class="btn btn-info btn-sm">Afficher</a>
                    <!-- Bouton pour éditer -->
                    <a href="{{ route('sims.edit', $sim->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                    <!-- Formulaire pour supprimer -->
                    <form action="{{ route('sims.destroy', $sim->id) }}" method="POST" style="display: inline;" class="delete-form">
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<!-- Lien vers votre fichier JS personnalisé -->
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
