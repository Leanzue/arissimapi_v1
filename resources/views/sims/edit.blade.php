<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Modifier une SIM</title>
    <link rel="stylesheet" href="{{ asset('public/css/custom.css') }}">
</head>
<body>
<header>
    <nav>
    </nav>
</header>
<main>
    <h1>Modifier une SIM</h1>
    <form method="POST" action="{{ url('api/sims/' . $sim->id) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="iccid">ICCID</label>
            <input type="text" class="form-control" id="iccid" name="iccid" value="{{ $sim->iccid }}" required>
        </div>
        <div class="form-group">
            <label for="imsi">IMSI</label>
            <input type="text" class="form-control" id="imsi" name="imsi" value="{{ $sim->imsi }}" required>
        </div>
        <div class="form-group">
            <label for="puk">PUK</label>
            <input type="text" class="form-control" id="puk" name="puk" value="{{ $sim->puk }}" required>
        </div>
        <div class="form-group">
            <label for="pin">PIN</label>
            <input type="text" class="form-control" id="pin" name="pin" value="{{ $sim->pin }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Modifier</button>
    </form>
</main>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
