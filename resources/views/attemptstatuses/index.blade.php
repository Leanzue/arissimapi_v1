<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attempt Statuses</title>
    <link rel="stylesheet" href="{{ asset('public/css/custom.css') }}">
</head>
<body>
<header>
    <nav>
    </nav>
</header>
<main>
    <h1>Attempt Statuses</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table mt-3">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nombre d'Essais</th>
            <th>Error Code</th>
            <th>Details</th>
            <th>Statut</th>
            <th>Comment</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($attemptstatuses as $attemptStatus)
            <tr>
                <td>{{ $attemptStatus->id }}</td>
                <td>{{ $attemptStatus->nombre_essais }}</td>
                <td>{{ $attemptStatus->error_code }}</td>
                <td>{{ $attemptStatus->details }}</td>
                <td>{{ $attemptStatus->statut }}</td>
                <td>{{ $attemptStatus->comment }}</td>
                <td class="actions-container">
                    <a href="{{ route('attemptstatuses.create') }}" class="btn btn-primary">New</a>
                    <a href="{{ route('attemptstatuses.show', $attemptStatus->id) }}" class="btn btn-warning">Show</a>
                    <a href="{{ route('attemptstatuses.edit', $attemptStatus->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('attemptstatuses.destroy', $attemptStatus->id) }}" method="POST" style="display: inline-block;">
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
<script src="{{ asset('public/js/app.js') }}"></script>
</body>
</html>
