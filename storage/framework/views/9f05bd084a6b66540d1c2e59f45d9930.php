<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Attempt Status</title>
    <!-- Ajout d'un framework CSS comme Bootstrap pour un style moderne -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Lien vers votre fichier CSS personnalisé -->
    <link rel="stylesheet" href="<?php echo e(asset('css/custom.css')); ?>">
</head>
<body>
<header class="bg-primary text-white text-center py-4">
    <h1>Create New Treatment Status</h1>
</header>

<main class="container my-5">
    <form action="<?php echo e(route('treatmentstatuses.store')); ?>" method="POST" class="needs-validation" novalidate>
        <?php echo csrf_field(); ?>
        <div class="mb-3">
            <label for="code" class="form-label">Code:</label>
            <input type="text" name="code" id="code" class="form-control" required>
            <div class="invalid-feedback">
                Please provide a valid code.
            </div>
        </div>

        <div class="mb-3">
            <label for="libelle" class="form-label">Libelle:</label>
            <input type="text" name="libelle" id="libelle" class="form-control" required>
            <div class="invalid-feedback">
                Please provide a valid libelle.
            </div>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description:</label>
            <textarea name="description" id="description" class="form-control" rows="3" required></textarea>
            <div class="invalid-feedback">
                Please provide a valid description.
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</main>

<!-- Ajout de Bootstrap JS et Popper.js pour les fonctionnalités interactives -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<!-- Lien vers votre fichier JS personnalisé -->
<script src="<?php echo e(asset('js/app.js')); ?>"></script>

<!-- Script pour la validation du formulaire -->
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function () {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
    })()
</script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\arissimapi\resources\views/treatmentstatuses/create.blade.php ENDPATH**/ ?>