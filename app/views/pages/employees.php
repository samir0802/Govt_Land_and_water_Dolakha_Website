<?php require __DIR__ . '/../partials/header.php'; ?>
<main class="container py-5">
    <h1 class="section-title">कर्मचारी</h1>
    <div class="row g-3">
        <?php foreach ($employees as $employee): ?>
            <div class="col-6 col-md-4 col-lg-3">
                <article class="card h-100">
                    <?php if (!empty($employee['photo_path'])): ?>
                        <img src="<?= asset('images/' . ltrim($employee['photo_path'], '/')); ?>" alt="<?= e(trField($employee, 'name')); ?>" class="card-img-top employee-thumb">
                    <?php endif; ?>
                    <div class="card-body">
                        <h2 class="h6 mb-1"><?= e(trField($employee, 'name')); ?></h2>
                        <p class="mb-0 text-muted"><?= e(trField($employee, 'designation')); ?></p>
                    </div>
                </article>
            </div>
        <?php endforeach; ?>
    </div>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
