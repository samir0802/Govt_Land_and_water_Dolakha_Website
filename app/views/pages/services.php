<?php require __DIR__ . '/../partials/header.php'; ?>
<main class="container py-5">
    <h1 class="section-title">सेवाहरू</h1>
    <div class="row g-3">
        <?php foreach ($services as $service): ?>
            <div class="col-md-4"><div class="card h-100"><div class="card-body">
                <h2 class="h5"><strong><?= e($service['title_np']); ?></strong></h2>
                <p class="mb-0"><?= e($service['description_np']); ?></p>
            </div></div></div>
        <?php endforeach; ?>
    </div>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
