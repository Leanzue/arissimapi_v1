<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier le traitement</title>
    <link rel="stylesheet" href="{{ asset('public/css/custom.css') }}">
</head>
<body>
<div class="container">
    <h1>Modifier le traitement</h1>
    <form method="POST" action="api/treatmentattempts/{{ $treatmentAttempt->id }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="date_debut">Date de début</label>
            <input type="date" class="form-control" id="date_debut" name="date_debut" value="{{ $treatmentAttempt->date_debut }}" required>
        </div>
        <div class="form-group">
            <label for="date_fin">Date de fin</label>
            <input type="date" class="form-control" id="date_fin" name="date_fin" value="{{ $treatmentAttempt->date_fin }}" required>
        </div>
        <div class="form-group">
            <label for="resultat">Résultat</label>
            <input type="text" class="form-control" id="resultat" name="resultat" value="{{ $treatmentAttempt->resultat }}">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description">{{ $treatmentAttempt->description }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
</body>
</html>
