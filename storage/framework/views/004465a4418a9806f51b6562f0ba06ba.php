<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Statut</title>
    <!-- Ajout de Bootstrap pour un style moderne -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Lien vers votre fichier CSS personnalisé -->
    <link rel="stylesheet" href="<?php echo e(asset('public/css/custom.css')); ?>">
</head>
<body>
<header class="bg-primary text-white text-center py-4">
    <h1>Modifier le Statut</h1>
</header>

<main class="container my-5">
    <form method="POST" action="<?php echo e(url('api/treatmentstatuses/'.$treatmentstatuses->id)); ?>" class="needs-validation" novalidate>
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class="mb-3">
            <label for="code" class="form-label">Code :</label>
            <input type="number" name="code" id="code" class="form-control" value="<?php echo e($treatmentstatuses->code); ?>" required>
            <div class="invalid-feedback">
                Veuillez fournir un code valide.
            </div>
        </div>

        <div class="mb-3">
            <label for="libelle" class="form-label">Libelle :</label>
            <input type="number" name="libelle" id="libelle" class="form-control" value="<?php echo e($treatmentstatuses->libelle); ?>" required>
            <div class="invalid-feedback">
                Veuillez fournir un libellé valide.
            </div>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description :</label>
            <textarea name="description" id="description" class="form-control" rows="3" required><?php echo e($treatmentstatuses->description); ?></textarea>
            <div class="invalid-feedback">
                Veuillez fournir une description valide.
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Mettre à Jour</button>
    </form>
</main>

<!-- Ajout de Bootstrap JS et Popper.js pour les fonctionnalités interactives -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<!-- Lien vers votre fichier JS personnalisé -->
<script src="<?php echo e(asset('js/app.js')); ?>"></script>

<!-- Script pour la validation du formulaire -->
<script>
</script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\arissimapi\resources\views/treatmentstatuses/edit.blade.php ENDPATH**/ ?>