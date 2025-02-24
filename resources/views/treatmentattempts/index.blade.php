<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Treatment</title>
    <link rel="stylesheet" href="{{ asset('public/css/c') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="container">
    <h1>Treatment</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table mt-3">
        <thead>
        <tr>
            <th>Date de début</th>
            <th>Date de fin</th>
            <th>Résultat</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($treatmentattempts as $treatmentattempt)
            <tr>
                <td>{{ $treatmentattempt->date_debut }}</td>
                <td>{{ $treatmentattempt->date_fin }}</td>
                <td>{{ $treatmentattempt->resultat }}</td>
                <td>{{ $treatmentattempt->description }}</td>
                <td class="actions-container">
                    <a href="{{ route('treatmentattempts.create') }}" class="btn btn-primary">New</a>
                    <a href="{{ route('treatmentattempts.show', $treatmentattempt->id) }}" class="btn btn-warning">Show</a>
                    <a href="{{ route('treatmentattempts.edit', $treatmentattempt->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('treatmentattempts.destroy', $treatmentattempt->id) }}" method="POST" style="display: inline-block;" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet élément ?');">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
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
