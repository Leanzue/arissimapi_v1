
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le résultat</title>
    <link rel="stylesheet" href="{{ asset('public/css/custom.css') }}">
</head>
<body>
<div class="container">
    <h1>Modifier le résultat</h1>
    <form method="POST" action="api/treatmentresults/{{ $treatmentresult->id }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="date_tentative">Date de tentative</label>
            <input type="date" class="form-control" id="date_tentative" name="date_tentative" value="{{ $treatmentresult->date_tentative }}" required>
        </div>
        <div class="form-group">
            <label for="details">Détails</label>
            <input type="text" class="form-control" id="details" name="details" value="{{ $treatmentresult->details }}" required>
        </div>
        <div class="form-group">
            <label for="resultat">Résultat</label>
            <input type="text" class="form-control" id="resultat" name="resultat" value="{{ $treatmentresult->resultat }}" required>
        </div>
        <div class="form-group">
            <label for="comment">Commentaire</label>
            <textarea class="form-control" id="comment" name="comment" required>{{ $treatmentresult->comment }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
</body>
</html>
