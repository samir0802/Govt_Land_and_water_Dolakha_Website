<?php require __DIR__ . '/../partials/header.php'; ?>
<main class="container py-5">
    <h1 class="section-title">ग्यालरी फोल्डरहरू</h1>
    <div class="row g-3">
        <?php foreach ($albums as $album): ?>
            <div class="col-md-4">
                <a class="card h-100 text-decoration-none" href="<?= $config['app']['base_url']; ?>?page=gallery&album=<?= (int) $album['id']; ?>">
                    <?php if (!empty($album['cover_image'])): ?><img src="<?= e(mediaUrl($config, $album['cover_image'])); ?>" class="card-img-top" alt="<?= e($album['title_np']); ?>"><?php endif; ?>
                    <div class="card-body">
                        <h2 class="h6"><?= e($album['title_np']); ?></h2>
                        <p class="mb-0 text-muted">Open folder</p>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
