<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Attempt Status</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/custom.css')); ?>">
</head>
<body>
<header>
    <nav>
    </nav>
</header>
<main>
    <h1>Create New TreatmentStatus</h1>
    <form action="<?php echo e(route('treatmentstatuses.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div>
            <label for="nombre_essais">Nombre d'Essais:</label>
            <input type="text" name="nombre_essais" id="nombre_essais" required>
        </div>
        <div>
            <label for="error_code">Error Code:</label>
            <input type="text" name="error_code" id="error_code" required>
        </div>
        <div>
            <label for="details">Details:</label>
            <input type="text" name="details" id="details" required>
        </div>
        <div>
            <label for="statut">Statut:</label>
            <input type="text" name="statut" id="statut" required>
        </div>
        <div>
            <label for="comment">Comment:</label>
            <input type="text" name="comment" id="comment">
        </div>
        <button type="submit">Create</button>
    </form>
</main>
<script src="<?php echo e(asset('js/app.js')); ?>"></script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\arissimapi\resources\views/treatmentstatuses/create.blade.php ENDPATH**/ ?>
