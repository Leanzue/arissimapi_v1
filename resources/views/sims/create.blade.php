<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Créer une Nouvelle SIM</title>
    <link rel="stylesheet" href="{{ asset('public/css/custom.css') }}">
</head>
<body>
<header>
    <nav>
    </nav>
</header>
<main>
    <h1>Créer une Nouvelle SIM</h1>
    <form action="{{ route('sims.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="iccid">ICCID</label>
            <input type="text" class="form-control" id="iccid" name="iccid" required>
        </div>
        <div class="form-group">
            <label for="imsi">IMSI</label>
            <input type="text" class="form-control" id="imsi" name="imsi" required>
        </div>
        <div class="form-group">
            <label for="puk">PUK</label>
            <input type="text" class="form-control" id="puk" name="puk" required>
        </div>
        <div class="form-group">
            <label for="pin">PIN</label>
            <input type="text" class="form-control" id="pin" name="pin" required>
        </div>
        <button type="submit" class="btn btn-primary">Créer</button>
    </form>
</main>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
