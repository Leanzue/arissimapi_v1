<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentatives d'Envoi</title>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<header>
    <nav>
        <!-- Votre navigation -->
    </nav>
</header>
<main>
    <h1>Tentatives d'Envoi</h1>

    <!-- Affichage des messages de succès ou d'erreur -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
@endif

<!-- Tableau des tentatives d'envoi -->
    <table class="table mt-3">
        <thead>
        <tr>
            <th>ID</th>
            <th>Données de Réponse</th>
            <th>Heure de Réponse</th>
            <th>Créé le</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($sendattempts as $sendAttempt)
            <tr>
                <td>{{ $sendAttempt->id }}</td>
                <td>{{ $sendAttempt->response_data }}</td>
                <td>{{ $sendAttempt->response_time }}</td>
                <td>{{ $sendAttempt->created_at->format('d/m/Y') }}</td>
                <td class="actions-container">
                    <a href="{{ route('sendattempts.show', $sendAttempt->id) }}" class="btn">Afficher</a>
                    <a href="{{ route('sendattempts.edit', $sendAttempt->id) }}" class="btn">Modifier</a>
                    <form action="{{ route('sendattempts.destroy', $sendAttempt->id) }}" method="POST" style="display: inline-block;" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet élément ?');">Supprimer</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <!-- Formulaire d'ajout -->
    <h2>Nouvelle Tentative d'Envoi</h2>
    <form method="POST" action="{{ route('sendattempts.store') }}">
    @csrf
    <!-- Champs du formulaire -->
        <div class="form-group">
            <label for="response_data">Données de Réponse</label>
            <input type="text" class="form-control" id="response_data" name="response_data" required>
        </div>
        <div class="form-group">
            <label for="response_time">Heure de Réponse</label>
            <input type="datetime-local" class="form-control" id="response_time" name="response_time" required>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
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
