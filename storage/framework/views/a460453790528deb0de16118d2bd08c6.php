<!-- resources/views/treatments/index.blade.php -->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index des Traitements</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('public/css/custom.css')); ?>">
</head>
<body>
<header class="bg-primary text-white text-center py-4">
    <h1>Index des Traitements</h1>
</header>

<main class="container my-5">
    <!-- Affichage des messages de succès -->
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
<?php endif; ?>

<!-- Tableau des traitements -->
    <table class="table table-striped table-hover">
        <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Classe Service</th>
            <th>Libellé Service</th>
            <th>Date de Début</th>
            <th>Date de Fin</th>
            <th>Description</th>
            <th>Tentative ID</th>
            <th>Status ID</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $treatment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $treatment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($treatment->id); ?></td>
                <td><?php echo e($treatment->service_class); ?></td>
                <td><?php echo e($treatment->libelle_service); ?></td>
                <td><?php echo e($treatment->date_debut); ?></td>
                <td><?php echo e($treatment->date_fin); ?></td>
                <td><?php echo e($treatment->description); ?></td>
                <td><?php echo e($treatment->treatment_attempt_id); ?></td>
                <td><?php echo e($treatment->treatment_status_id); ?></td>
                <td class="actions-container">
                    <!-- Bouton pour afficher les détails -->
                    <a href="<?php echo e(route('treatments.show', $treatment->id)); ?>" class="btn btn-info btn-sm">Afficher</a>
                    <!-- Bouton pour éditer -->
                    <a href="<?php echo e(route('treatments.edit', $treatment->id)); ?>" class="btn btn-warning btn-sm">Modifier</a>
                    <!-- Formulaire pour supprimer -->
                    <form action="<?php echo e(route('treatments.destroy', $treatment->id)); ?>" method="POST" style="display: inline-block;" class="delete-form">
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

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo e(asset('js/app.js')); ?>"></script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\arissimapi\resources\views/Treatments/index.blade.php ENDPATH**/ ?>