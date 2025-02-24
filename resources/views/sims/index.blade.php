<!DOCTYPE html>
<html lang="fr">
<head>
    <title>SIMS</title>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body>
<header>
    <nav>
    </nav>
</header>
<main>
    <h1>SIMS</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>ICCID</th>
            <th>IMSI</th>
            <th>PUK</th>
            <th>PIN</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($sims as $sim)
            <tr>
                <td>{{ $sim->id }}</td>
                <td>{{ $sim->iccid }}</td>
                <td>{{ $sim->imsi }}</td>
                <td>{{ $sim->puk }}</td>
                <td>{{ $sim->pin }}</td>
                <td class="actions-container">
                    <a href="{{ route('sims.create') }}">New</a>
                    <a href="{{ route('sims.show', $sim->id) }}">Show</a>
                    <a href="{{ route('sims.edit', $sim->id) }}">Edit</a>
                    <form action="{{ route('sims.destroy', $sim->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this item?');">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</main>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
