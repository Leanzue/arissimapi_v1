<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats des Traitements</title>
    <link rel="stylesheet" href="{{ asset('public/css/custom.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="container">
    <h1>Résultats des Traitements</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table mt-3">
        <thead>
        <tr>
            <th>Date de tentative</th>
            <th>Détails</th>
            <th>Résultat</th>
            <th>Commentaire</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($attemptresults as $treatementResult)
            <tr>
                <td>{{ $treatementResult->date_tentative }}</td>
                <td>{{ $treatementResult->details }}</td>
                <td>{{ $treatementResult->resultat }}</td>
                <td>{{ $treatementResult->comment }}</td>
                <td class="actions-container">
                    <a href="{{ route('attemptresults.create') }}" class="btn btn-primary">New</a>
                    <a href="{{ route('attemptresults.show', $treatementResult->id) }}" class="btn btn-warning">Show</a>
                    <a href="{{ route('attemptresults.edit', $treatementResult->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('attemptresults.destroy', $treatementResult->id) }}" method="POST" style="display: inline-block;" class="delete-form">
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
