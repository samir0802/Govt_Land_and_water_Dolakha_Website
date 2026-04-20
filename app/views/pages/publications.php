<?php require __DIR__ . '/../partials/header.php'; ?>
<main class="container py-5">
    <h1 class="section-title">प्रकाशन</h1>
    <div class="list-group">
        <?php foreach ($publications as $publication): ?>
            <article class="list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-between">
                    <h2 class="h6 mb-1"><?= e($publication['title_np']); ?></h2>
                    <small><?= e(date('Y-m-d', strtotime($publication['published_at']))); ?></small>
                </div>
                <p class="mb-0 small"><?= e($publication['summary_np'] ?? ''); ?></p>
            </article>
        <?php endforeach; ?>
    </div>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
