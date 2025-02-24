<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Results</title>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<header>
    <nav>
    </nav>
</header>
<main>
    <h1>Send Results</h1>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table mt-3">
        <thead>
        <tr>
            <th>ID</th>
            <th>Result Description</th>
            <th>Nombre Tentative</th>
            <th>Date Envoi</th>
            <th>Error Code</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($sendresults as $sendResult)
            <tr>
                <td>{{ $sendResult->id }}</td>
                <td>{{ $sendResult->result_description }}</td>
                <td>{{ $sendResult->nombre_tentative }}</td>
                <td>{{ $sendResult->date_envoi }}</td>
                <td>{{ $sendResult->error_code }}</td>
                <td class="actions-container">
                    <a href="{{ route('sendresults.create') }}" class="btn btn-primary">New</a>
                    <a href="{{ route('sendresults.show', $sendResult->id) }}" class="btn btn-warning">Show</a>
                    <a href="{{ route('sendresults.edit', $sendResult->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('sendresults.destroy', $sendResult->id) }}" method="POST" style="display: inline-block;" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet élément ?');">Delete</button>
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
                    if (result.success) {
                        form.closest('tr').remove();
                        alert(result.message);
                    } else {
                        alert('Une erreur est survenue : ' + result.error);
                    }
                },
                error: function(xhr) {
                    alert('Une erreur est survenue lors de la suppression de l\'élément');
                }
            });
        }
    });
</script>
</body>
</html>
