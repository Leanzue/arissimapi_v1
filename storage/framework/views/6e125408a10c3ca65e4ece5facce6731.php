<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le traitement</title>
    <!-- Ajout de Bootstrap pour un style moderne -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Lien vers votre fichier CSS personnalisé -->
    <link rel="stylesheet" href="<?php echo e(asset('public/css/custom.css')); ?>">
</head>
<body>
<header class="bg-primary text-white text-center py-4">
    <h1>Modifier le traitement</h1>
</header>

<main class="container my-5">
    <form method="POST" action="api/treatmentattempts/<?php echo e($treatmentAttempt->id); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class="mb-3">
            <label for="date_debut" class="form-label">Date de début</label>
            <input type="date" class="form-control" id="date_debut" name="date_debut" value="<?php echo e($treatmentAttempt->date_debut); ?>" required>
        </div>
        <div class="mb-3">
            <label for="date_fin" class="form-label">Date de fin</label>
            <input type="date" class="form-control" id="date_fin" name="date_fin" value="<?php echo e($treatmentAttempt->date_fin); ?>" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" required><?php echo e($treatmentAttempt->description); ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</main>

<!-- Ajout de Bootstrap JS et Popper.js pour les fonctionnalités interactives -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<!-- Lien vers votre fichier JS personnalisé -->
<script src="<?php echo e(asset('public/js/app.js')); ?>"></script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\arissimapi\resources\views/treatmentattempts/edit.blade.php ENDPATH**/ ?>