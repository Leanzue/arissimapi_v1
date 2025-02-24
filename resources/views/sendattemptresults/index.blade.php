<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de Tentative d'Envoi</title>
    <link rel="stylesheet" href="{{ asset('public/css/custom.css') }}">
    <style>
        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<header>
    <nav>
    </nav>
</header>
<main>
    <h1>Résultats de Tentative d'Envoi</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table mt-3">
        <thead>
        <tr>
            <th>ID</th>
            <th>Date d'Envoi des Résultats</th>
            <th>Détails</th>
            <th>Code d'Erreur</th>
            <th>Nombre de Tentatives</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($sendattemptresults as $sendAttemptResult)
            <tr>
                <td>{{ $sendAttemptResult->id }}</td>
                <td>{{ $sendAttemptResult->date_of_sending_results }}</td>
                <td>{{ $sendAttemptResult->details }}</td>
                <td>{{ $sendAttemptResult->error_code }}</td>
                <td>{{ $sendAttemptResult->nombre_de_tentative }}</td>
                <td class="actions-container">
                    <a href="{{ route('sendattemptresults.create') }}" class="btn btn-primary">Nouveau</a>
                    <a href="{{ route('sendattemptresults.show', $sendAttemptResult->id) }}" class="btn btn-warning">Afficher</a>
                    <a href="{{ route('sendattemptresults.edit', $sendAttemptResult->id) }}" class="btn btn-warning">Modifier</a>
                    <form action="{{ route('sendattemptresults.destroy', $sendAttemptResult->id) }}" method="POST" style="display: inline-block;" class="delete-form">
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
        e.preventDefault(); // Prevent form from submitting traditionally

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
                    // Handle success (e.g., removing the row from the table)
                    form.closest('tr').remove();
                    alert('Élément supprimé avec succès');
                },
                error: function(xhr) {
                    // Handle error
                    alert('Une erreur est survenue lors de la suppression de l\'élément');
                }
            });
        }
    });
</script>
</body>
</html>
