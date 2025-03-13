<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attempt Statuses</title>
    <link rel="stylesheet" href="<?php echo e(asset('public/css/custom.css')); ?>">
</head>
<body>
<header>
    <nav>
    </nav>
</header>
<main>
    <h1>Attempt Statuses</h1>

    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <table class="table mt-3">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nombre d'Essais</th>
            <th>Error Code</th>
            <th>Details</th>
            <th>Statut</th>
            <th>Comment</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $treatmentstatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attemptStatus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($attemptStatus->id); ?></td>
                <td><?php echo e($attemptStatus->nombre_essais); ?></td>
                <td><?php echo e($attemptStatus->error_code); ?></td>
                <td><?php echo e($attemptStatus->details); ?></td>
                <td><?php echo e($attemptStatus->statut); ?></td>
                <td><?php echo e($attemptStatus->comment); ?></td>
                <td class="actions-container">
                    <a href="<?php echo e(route('treatmentstatuses.create')); ?>" class="btn btn-primary">New</a>
                    <a href="<?php echo e(route('treatmentstatuses.show', $attemptStatus->id)); ?>" class="btn btn-warning">Show</a>
                    <a href="<?php echo e(route('treatmentstatuses.edit', $attemptStatus->id)); ?>" class="btn btn-warning">Edit</a>
                    <form action="<?php echo e(route('treatmentstatuses.destroy', $attemptStatus->id)); ?>" method="POST" style="display: inline-block;">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?');">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</main>
<script src="<?php echo e(asset('public/js/app.js')); ?>"></script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\arissimapi\resources\views/treatmentstatuses/index.blade.php ENDPATH**/ ?>
