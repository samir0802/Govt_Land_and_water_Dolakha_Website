<?php require __DIR__ . '/../partials/header.php'; ?>
<?php require __DIR__ . '/../partials/sidebar.php'; ?>
<main class="col-lg-10 p-4 bg-light">
    <a class="btn btn-outline-secondary mb-3" href="<?= url('admin/index.php?page=gallery'); ?>">Back</a>
    <form method="POST" enctype="multipart/form-data" action="<?= url('admin/index.php?page=gallery&action=upload&id=' . (int) $album['id']); ?>" class="mb-4">
        <input type="file" name="media_files[]" multiple class="form-control mb-2">
        <button class="btn btn-primary">Upload</button>
    </form>
    <div class="row g-3">
        <?php foreach ($mediaItems as $item): ?>
            <div class="col-md-4"><?php if ($item['media_type'] === 'video'): ?><video controls class="w-100"><source src="<?= asset('images/' . ltrim($item['image_path'], '/')); ?>"></video><?php else: ?><img class="img-fluid" src="<?= asset('images/' . ltrim($item['image_path'], '/')); ?>"><?php endif; ?></div>
        <?php endforeach; ?>
    </div>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
