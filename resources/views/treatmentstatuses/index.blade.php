<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Treatment Statuses</title>
    <!-- Ajout de Bootstrap pour un style moderne -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Lien vers votre fichier CSS personnalisé -->
    <link rel="stylesheet" href="{{ asset('public/css/custom.css') }}">
</head>
<body>
<header class="bg-primary text-white text-center py-4">
    <h1>Treatment Statuses</h1>
</header>

<main class="container my-5">
    <!-- Affichage des messages de succès -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
@endif

<!-- Tableau des statuts de traitement -->
    <table class="table table-striped table-hover">
        <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Code</th>
            <th>Libelle</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($treatmentstatuses as $treatmentstatus)
            <tr>
                <td>{{ $treatmentstatus->id }}</td>
                <td>{{ $treatmentstatus->code }}</td>
                <td>{{ $treatmentstatus->libelle }}</td>
                <td>{{ $treatmentstatus->description }}</td>
                <td class="actions-container">
                    <!-- Bouton pour créer un nouveau statut -->
                    <a href="{{ route('treatmentstatuses.create') }}" class="btn btn-primary btn-sm">New</a>
                    <!-- Bouton pour afficher les détails -->
                    <a href="{{ route('treatmentstatuses.show', $treatmentstatus->id) }}" class="btn btn-info btn-sm">Show</a>
                    <!-- Bouton pour éditer -->
                    <a href="{{ route('treatmentstatuses.edit', $treatmentstatus->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <!-- Formulaire pour supprimer -->
                    <form action="{{ route('treatmentstatuses.destroy', $treatmentstatus->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?');">Delete</button>
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
<script src="{{ asset('public/js/app.js') }}"></script>
</body>
</html>
