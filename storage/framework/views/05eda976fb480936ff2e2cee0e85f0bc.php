<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats des Traitements</title>
    <link rel="stylesheet" href="<?php echo e(asset('public/css/custom.css')); ?>">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="container">
    <h1>Résultats des Traitements</h1>

    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <table class="table mt-3">
        <thead>
        <tr>
            <th>Date de tentative</th>
            <th>Détails</th>
            <th>Résultat</th>
            <th>Commentaire</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $treatmentresults; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $treatmentresult): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($treatmentresult->date_tentative); ?></td>
                <td><?php echo e($treatmentresult->details); ?></td>
                <td><?php echo e($treatmentresult->resultat); ?></td>
                <td><?php echo e($treatmentresult->comment); ?></td>
                <td class="actions-container">
                    <a href="<?php echo e(route('treatmentresults.create')); ?>" class="btn btn-primary">New</a>
                    <a href="<?php echo e(route('treatmentresults.show', $treatmentresult->id)); ?>" class="btn btn-warning">Show</a>
                    <a href="<?php echo e(route('treatmentresults.edit', $treatmentresult->id)); ?>" class="btn btn-warning">Edit</a>
                    <form action="<?php echo e(route('treatmentresults.destroy', $treatmentresult->id)); ?>" method="POST" style="display: inline-block;" class="delete-form">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet élément ?');">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<script src="<?php echo e(asset('js/app.js')); ?>"></script>
<script>
    $(document).on('submit', '.delete-form', function(e) {
        e.preventDefault(); // Empêche la soumission traditionnelle du formulaire

        if (confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')) {
            let form = $(this);
            let url = form.attr('action');
            let token = $('input[name=_token]').val();

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _method: 'DELETE',
                    _token: token
                },
                success: function(result) {
                    // Supprime la ligne correspondante du tableau en cas de succès
                    form.closest('tr').remove();
                    alert('Élément supprimé avec succès');
                },
                error: function(xhr) {
                    // Gère les erreurs
                    alert('Une erreur est survenue lors de la suppression de l\'élément');
                }
            });
        }
    });
</script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\arissimapi\resources\views/treatmentresults/index.blade.php ENDPATH**/ ?>
