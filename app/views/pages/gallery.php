<?php require __DIR__ . '/../partials/header.php'; ?>
<main class="container py-5">
    <h1 class="section-title">ग्यालरी</h1>
    <div class="row g-3">
        <?php foreach ($gallery as $image): ?>
            <div class="col-6 col-md-4 col-lg-3">
                <figure class="mb-0">
                    <img src="<?= e($image['image_path']); ?>" alt="<?= e($image['title_np']); ?>" class="img-fluid rounded shadow-sm gallery-thumb">
                    <figcaption class="small mt-2"><?= e($image['title_np']); ?></figcaption>
                </figure>
            </div>
        <?php endforeach; ?>
    </div>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
