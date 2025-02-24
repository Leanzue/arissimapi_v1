<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Types</title>
    <link rel="stylesheet" href="{{ asset('public/css/custom.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<header>
    <nav>
    </nav>
</header>
<main>
    <h1>Request Types</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table mt-3">
        <thead>
        <tr>
            <th>ID</th>
            <th>Action</th>
            <th>Libellé</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($requestTypes as $requestType)
            <tr>
                <td>{{ $requestType->id }}</td>
                <td>{{ $requestType->action }}</td>
                <td>{{ $requestType->libellé }}</td>
                <td class="actions-container">
                    <a href="{{ route('requestTypes.create') }}" class="btn btn-primary">New</a>
                    <a href="{{ route('requestTypes.show', $requestType->id) }}" class="btn btn-warning">Show</a>
                    <a href="{{ route('requestTypes.edit', $requestType->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('requestTypes.destroy', $requestType->id) }}" method="POST" style="display: inline-block;" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?');">Delete</button>
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

        if (confirm('Are you sure you want to delete this item?')) {
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
                    alert('Item successfully deleted');
                },
                error: function(xhr) {
                    // Handle error
                    alert('An error occurred while deleting the item');
                }
            });
        }
    });
</script>
</body>
</html>
