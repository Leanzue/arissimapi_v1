<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status</title>
    <!-- Ajout de Bootstrap pour un style moderne -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Lien vers votre fichier CSS personnalisé -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<header class="bg-primary text-white text-center py-4">
    <h1>Status</h1>
</header>

<main class="container my-5">
    <!-- Affichage des messages de succès -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
@endif

<!-- Bouton pour créer un nouveau statut -->
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('statuses.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Nouveau
        </a>
    </div>

    <!-- Tableau des statuts -->
    <table class="table table-striped table-hover">
        <thead class="table-dark">
        <tr>
            <th>Nom</th>
            <th>Code</th>
            <th>Style</th>
            <th>Est par défaut</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($statuses as $status)
            <tr>
                <td>{{ $status->name }}</td>
                <td>{{ $status->code }}</td>
                <td>{{ $status->style }}</td>
                <td>{{ $status->is_default }}</td>
                <td>{{ $status->description }}</td>
                <td class="actions-container">
                    <!-- Bouton pour afficher les détails -->
                    <a href="{{ route('statuses.show', $status->id) }}" class="btn btn-info btn-sm">Afficher</a>
                    <!-- Bouton pour éditer -->
                    <a href="{{ route('statuses.edit', $status->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                    <!-- Formulaire pour supprimer -->
                    <form action="{{ route('statuses.destroy', $status->id) }}" method="POST" style="display: inline-block;" class="delete-form">
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
<script>
    $(document).on('submit', '.delete-form', function(e) {
        e.preventDefault(); // Empêche la soumission traditionnelle du formulaire

        if (confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')) {
            let form = $(this);
            let url = form.attr('action');
            let token = $('input[name=_token]').val();

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _method: 'DELETE',
                    _token: token
                },
                success: function(result) {
                    // Supprime la ligne correspondante du tableau en cas de succès
                    form.closest('tr').remove();
                    alert('Élément supprimé avec succès');
                },
                error: function(xhr) {
                    // Gère les erreurs
                    alert('Une erreur est survenue lors de la suppression de l\'élément');
                }
            });
        }
    });
</script>
</body>
</html>
