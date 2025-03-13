<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats des Traitements</title>
    <!-- Ajout de Bootstrap pour un style moderne -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Lien vers votre fichier CSS personnalisé -->
    <link rel="stylesheet" href="<?php echo e(asset('public/css/custom.css')); ?>">
</head>
<body>
<header class="bg-primary text-white text-center py-4">
    <h1>Résultats des Traitements</h1>
</header>

<main class="container my-5">
    <!-- Affichage des messages de succès -->
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
<?php endif; ?>

<!-- Bouton pour créer un nouveau résultat -->
    <div class="d-flex justify-content-end mb-3">
        <a href="<?php echo e(route('treatmentresults.create')); ?>" class="btn btn-success">
            <i class="fas fa-plus"></i> Nouveau
        </a>
    </div>

    <!-- Tableau des résultats de traitement -->
    <table class="table table-striped table-hover">
        <thead class="table-dark">
        <tr>
            <th>Résultat</th>
            <th>Libellé</th>
            <th>Détails</th>
            <th>posi</th>
        </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $treatmentresults; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $treatmentresult): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($treatmentresult->resultat); ?></td>
                <td><?php echo e($treatmentresult->libelle); ?></td>
                <td><?php echo e($treatmentresult->details); ?></td>
                <td><?php echo e($treatmentresult->posi); ?></td>
                <td class="actions-container">
                    <!-- Bouton pour afficher les détails -->
                    <a href="<?php echo e(route('treatmentresults.show', $treatmentresult->id)); ?>" class="btn btn-info btn-sm">Afficher</a>
                    <!-- Bouton pour éditer -->
                    <a href="<?php echo e(route('treatmentresults.edit', $treatmentresult->id)); ?>" class="btn btn-warning btn-sm">Modifier</a>
                    <!-- Formulaire pour supprimer -->
                    <form action="<?php echo e(route('treatmentresults.destroy', $treatmentresult->id)); ?>" method="POST" style="display: inline-block;">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet élément ?');">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</main>

<!-- Ajout de Bootstrap JS et Popper.js pour les fonctionnalités interactives -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<!-- Lien vers votre fichier JS personnalisé -->
<script src="<?php echo e(asset('public/js/app.js')); ?>"></script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\arissimapi\resources\views/treatmentresults/index.blade.php ENDPATH**/ ?>