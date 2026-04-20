<?php require __DIR__ . '/../partials/header.php'; ?>
<main class="container py-5">
    <h1 class="section-title">सेवा</h1>
    <div class="row g-3">
        <?php foreach ($services as $service): ?>
            <div class="col-md-6">
                <article class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h2 class="h5"><?= e($service['title_np']); ?></h2>
                        <p class="mb-0"><?= e($service['description_np']); ?></p>
                    </div>
                </article>
            </div>
        <?php endforeach; ?>
    </div>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
