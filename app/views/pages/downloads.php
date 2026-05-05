<?php require __DIR__ . '/../partials/header.php'; ?>
<main class="container py-5">
    <h1 class="section-title">डाउनलोड</h1>
    <div class="row g-3">
        <?php foreach ($downloads as $file): ?>
            <div class="col-md-4">
                <a class="card card-body text-decoration-none" href="<?= asset('images/' . ltrim($file['file_path'], '/')); ?>" target="_blank">
                    <?= e($file['title_np']); ?>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
