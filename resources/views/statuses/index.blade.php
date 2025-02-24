<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status</title>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="container">
    <h1>Status</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table mt-3">
        <thead>
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
                    <a href="{{ route('statuses.create') }}" class="btn btn-primary">New</a>
                    <a href="{{ route('statuses.show', $status->id) }}" class="btn btn-warning">show</a>
                    <a href="{{ route('statuses.edit', $status->id) }}" class="btn btn-warning">edit</a>
                    <form action="{{ route('statuses.destroy', $status->id) }}" method="POST" style="display: inline-block;" class="delete-form">
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
