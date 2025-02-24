<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RequestStatus</title>
    <link rel="stylesheet" href="{{ asset('public/css/custom.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<header>
    <nav>
    </nav>
</header>
<main>
    <h1>RequestStatus</h1>

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
        @foreach ($requestStatuses as $requestStatus)
            <tr>
                <td>{{ $requestStatus->id }}</td>
                <td>{{ $requestStatus->priority }}</td>
                <td>{{ $requestStatus->libellé }}</td>
                <td class="actions-container">
                    <a href="{{ route('requeststatuses.create') }}" class="btn btn-primary">New</a>
                    <a href="{{ route('requeststatuses.show', $requestStatus->id) }}" class="btn btn-warning">Show</a>
                    <a href="{{ route('requeststatuses.edit', $requestStatus->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('requeststatuses.destroy', $requestStatus->id) }}" method="POST" style="display: inline-block;" class="delete-form">
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
        e.preventDefault();

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
