<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Statut</title>
    <link rel="stylesheet" href="<?php echo e(asset('public/css/custom.css')); ?>">
</head>
<body>
<header>
    <nav>
    </nav>
</header>
<main>
    <h1>Modifier le Statut</h1>
    <form method="POST" action="<?php echo e(url('api/treatmentstatuses/'.$treatmentstatuses->id)); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div>
            <label for="nombre_essais">Nombre d'Essais :</label>
            <input type="number" name="nombre_essais" id="nombre_essais" value="<?php echo e($treatmentstatuses->nombre_essais); ?>" required>
        </div>
        <div>
            <label for="error_code">Code d'Erreur :</label>
            <input type="number" name="error_code" id="error_code" value="<?php echo e($treatmentstatuses->error_code); ?>" required>
        </div>
        <div>
            <label for="details">Détails :</label>
            <input type="text" name="details" id="details" value="<?php echo e($treatmentstatuses->details); ?>" required>
        </div>
        <div>
            <label for="status">Statut :</label>
            <input type="text" name="status" id="status" value="<?php echo e($treatmentstatuses->status); ?>" required>
        </div>
        <div>
            <label for="comment">Commentaire :</label>
            <input type="text" name="comment" id="comment" value="<?php echo e($treatmentstatuses->comment); ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Mettre à Jour</button>
    </form>
</main>
<script src="<?php echo e(asset('js/app.js')); ?>"></script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\arissimapi\resources\views/treatmentstatuses/edit.blade.php ENDPATH**/ ?>
