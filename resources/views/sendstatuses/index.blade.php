<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Statuts d'Envoi</title>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<header>
    <nav>
    </nav>
</header>
<main>
    <h1>Statuts d'Envoi</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table mt-3">
        <thead>
        <tr>
            <th>ID</th>
            <th>Priorité</th>
            <th>Libellé</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($sendstatuses as $sendStatus)
            <tr>
                <td>{{ $sendStatus->id }}</td>
                <td>{{ $sendStatus->priority }}</td>
                <td>{{ $sendStatus->libellé }}</td>
                <td class="actions-container">
                    <a href="{{ route('sendstatuses.create') }}" class="btn btn-primary">Nouveau</a>
                    <a href="{{ route('sendstatuses.show', $sendStatus->id) }}" class="btn btn-warning">Afficher</a>
                    <a href="{{ route('sendstatuses.edit', $sendStatus->id) }}" class="btn btn-warning">Modifier</a>
                    <form action="{{ route('sendstatuses.destroy', $sendStatus->id) }}" method="POST" style="display: inline-block;" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet élément ?');">Supprimer</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</main>
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
