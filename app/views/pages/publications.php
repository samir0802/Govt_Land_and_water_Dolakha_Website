<?php require __DIR__ . '/../partials/header.php'; ?>
<main class="container py-5">
    <h1 class="section-title">प्रकाशन</h1>
    <ul class="list-group">
        <?php foreach ($publications as $item): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span><?= e($item['title_np']); ?></span>
                <small><?= e(date('Y-m-d', strtotime($item['published_at']))); ?></small>
            </li>
        <?php endforeach; ?>
    </ul>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
