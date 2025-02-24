
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un nouveau résultat</title>
    <link rel="stylesheet" href="{{ asset('public/css/custom.css') }}">
</head>
<body>
<div class="container">
    <h1>Créer un nouveau résultat</h1>
    <form action="{{ route('attemptresults.store')  }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="date_tentative">Date de tentative</label>
            <input type="date" class="form-control" id="date_tentative" name="date_tentative" required>
        </div>
        <div class="form-group">
            <label for="details">Détails</label>
            <input type="text" class="form-control" id="details" name="details" required>
        </div>
        <div class="form-group">
            <label for="resultat">Résultat</label>
            <input type="text" class="form-control" id="resultat" name="resultat" required>
        </div>
        <div class="form-group">
            <label for="comment">Commentaire</label>
            <textarea class="form-control" id="comment" name="comment" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Créer</button>
    </form>
</div>
</body>
</html>
