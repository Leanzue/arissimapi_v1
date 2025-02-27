<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Requêtes SIM</title>
    <link rel="stylesheet" href="{{ asset('public/css/custom.css') }}">
</head>
<body>
<header>
    <nav>
    </nav>
</header>
<main>
    <h1>Requêtes SIM</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table mt-3">
        <thead>
        <tr>
            <th>ID</th>
            <th>Code</th>
            <th>client_IP_Adresse</th>
            <th>Url_reponse</th>
            <th>file_prefix</th>
            <th>file_extension</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($simrequests as $simRequest)
            <tr>
                <td>{{ $simRequest->id }}</td>
                <td>{{ $simRequest->description }}</td>
                <td>{{ $simRequest->adresse_ip }}</td>
                <td>{{ $simRequest->date }}</td>
                <td>{{ $simRequest->code }}</td>
                <td class="actions-container">
                    <a href="{{ route('simrequests.create') }}" class="btn btn-primary">New</a>
                    <a href="{{ route('simrequests.show', $simRequest->id) }}" class="btn btn-warning">Show</a>
                    <a href="{{ route('simrequests.edit', $simRequest->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('simrequests.destroy', $simRequest->id) }}" method="POST" style="display: inline-block;">
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
