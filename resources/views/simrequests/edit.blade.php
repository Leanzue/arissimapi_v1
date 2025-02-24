<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Modifier une Requête SIM</title>
    <link rel="stylesheet" href="{{ asset('public/css/custom.css') }}">
</head>
<body>
<header>
    <nav>
    </nav>
</header>
<main>
    <h1>Modifier une Requête SIM</h1>
    <form method="POST"action="api/simrequests{{$simRequest->id}}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" class="form-control" id="description" name="description" value="{{ $simRequest->description }}" required>
        </div>
        <div class="form-group">
            <label for="adresse_ip">Adresse IP</label>
            <input type="text" class="form-control" id="adresse_ip" name="adresse_ip" value="{{ $simRequest->adresse_ip }}" required>
        </div>
        <div class="form-group">
            <label for="date">Date</label>
            <input type="text" class="form-control" id="date" name="date" value="{{ $simRequest->date }}" required>
        </div>
        <div class="form-group">
            <label for="code">Code</label>
            <input type="text" class="form-control" id="code" name="code" value="{{ $simRequest->code }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Modifier</button>
    </form>
</main>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
