<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un nouveau statut</title>
    <!-- Ajout de Bootstrap pour un style moderne -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Lien vers votre fichier CSS personnalisé -->
    <link rel="stylesheet" href="<?php echo e(asset('public/css/custom.css')); ?>">
</head>
<body>
<header class="bg-primary text-white text-center py-4">
    <h1>Créer un nouveau statut</h1>
</header>

<main class="container my-5">
    <form action="<?php echo e(route('statuses.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="code" class="form-label">Code</label>
            <input type="text" class="form-control" id="code" name="code" required>
        </div>
        <div class="mb-3">
            <label for="style" class="form-label">Style</label>
            <input type="text" class="form-control" id="style" name="style" required>
        </div>
        <div class="mb-3">
            <label for="is_default" class="form-label">Est par défaut</label>
            <input type="text" class="form-control" id="is_default" name="is_default" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Créer</button>
    </form>
</main>

<!-- Ajout de Bootstrap JS et Popper.js pour les fonctionnalités interactives -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<!-- Lien vers votre fichier JS personnalisé -->
<script src="<?php echo e(asset('public/js/app.js')); ?>"></script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\arissimapi\resources\views/statuses/create.blade.php ENDPATH**/ ?>