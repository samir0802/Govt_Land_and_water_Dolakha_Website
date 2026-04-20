<?php require __DIR__ . '/../partials/header.php'; ?>
<main class="container py-5">
    <h1 class="section-title">डाउनलोड</h1>
    <div class="list-group">
        <?php foreach ($downloads as $download): ?>
            <a href="<?= e($download['file_path']); ?>" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between">
                <span><?= e($download['title_np']); ?></span>
                <small><?= e(date('Y-m-d', strtotime($download['published_at']))); ?></small>
            </a>
        <?php endforeach; ?>
    </div>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
