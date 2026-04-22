<?php require __DIR__ . '/../partials/header.php'; ?>
<?php require __DIR__ . '/../partials/sidebar.php'; ?>
<main class="col-lg-10 p-4 bg-light">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Album: <?= e($album['title_np']); ?></h1>
        <a class="btn btn-outline-secondary" href="<?= $config['app']['base_url'] ?>admin/index.php?page=gallery">Back to folders</a>
    </div>

    <?php if (!empty($_SESSION['admin_success'])): ?><div class="alert alert-success"><?= e($_SESSION['admin_success']); ?></div><?php unset($_SESSION['admin_success']); endif; ?>

    <div class="card mb-4">
        <div class="card-header">Upload more files</div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data" action="<?= $config['app']['base_url'] ?>admin/index.php?page=gallery&action=upload&id=<?= (int) $album['id']; ?>" class="row g-3">
                <div class="col-12"><input type="file" name="media_files[]" multiple accept="image/png,image/jpeg,video/mp4,video/webm,video/quicktime" class="form-control"></div>
                <div class="col-12"><button class="btn btn-primary">Upload Media</button></div>
            </form>
        </div>
    </div>

    <div class="row g-3">
        <?php foreach ($mediaItems as $item): ?>
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <?php if ($item['media_type'] === 'video'): ?>
                            <video controls style="width:100%;max-height:220px;"><source src="<?= e($item['media_path']); ?>"></video>
                        <?php else: ?>
                            <img src="<?= e($item['media_path']); ?>" alt="gallery media" class="img-fluid rounded">
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
