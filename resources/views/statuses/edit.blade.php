<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le statut</title>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body>
<div class="container">
    <h1>Modifier le statut</h1>
    <form method="POST" action="{{ url('api/statuses/' . $status->id) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nom</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $status->name }}" required>
        </div>
        <div class="form-group">
            <label for="code">Code</label>
            <input type="text" class="form-control" id="code" name="code" value="{{ $status->code }}" required>
        </div>
        <div class="form-group">
            <label for="style">Style</label>
            <input type="text" class="form-control" id="style" name="style" value="{{ $status->style }}" required>
        </div>
        <div class="form-group">
            <label for="is_default">Est par défaut</label>
            <input type="checkbox" class="form-control" id="is_default" name="is_default" {{ $status->is_default ? 'checked' : '' }} required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" required>{{ $status->description }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
</body>
</html>
