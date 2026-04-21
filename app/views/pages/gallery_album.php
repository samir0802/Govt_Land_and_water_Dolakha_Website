<?php require __DIR__ . '/../partials/header.php'; ?>
<main class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="section-title mb-0"><?= e($album['title_np']); ?></h1>
        <a class="btn btn-outline-primary" href="<?= $config['app']['base_url']; ?>?page=gallery">Back to folders</a>
    </div>

    <div class="row g-3">
        <?php foreach ($mediaItems as $item): ?>
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <?php if ($item['media_type'] === 'video'): ?>
                            <video controls class="w-100"><source src="<?= e($item['media_path']); ?>"></video>
                        <?php else: ?>
                            <img src="<?= e($item['media_path']); ?>" class="img-fluid rounded" alt="<?= e($album['title_np']); ?>">
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
