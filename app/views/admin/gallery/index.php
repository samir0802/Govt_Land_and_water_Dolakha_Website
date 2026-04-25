<?php require __DIR__ . '/../partials/header.php'; ?>
<?php require __DIR__ . '/../partials/sidebar.php'; ?>
<main class="col-lg-10 p-4 bg-light">
    <h1 class="h3 mb-3">Gallery Manager</h1>
    <form method="POST" enctype="multipart/form-data" action="<?= url('admin/index.php?page=gallery&action=create'); ?>" class="row g-3 mb-4">
        <div class="col-md-4"><input name="title_np" required class="form-control" placeholder="Album title"></div>
        <div class="col-md-4"><input type="date" name="event_date" class="form-control"></div>
        <div class="col-md-4"><input type="file" name="media_files[]" multiple accept="image/png,image/jpeg,video/mp4,video/webm,video/quicktime" class="form-control"></div>
        <div class="col-12"><button class="btn btn-primary">Create Folder</button></div>
    </form>
    <table class="table table-striped">
        <?php foreach ($albums as $album): ?>
            <tr><td><?= e($album['title_np']); ?></td><td><?= (int) $album['total_items']; ?></td>
                <td><a class="btn btn-sm btn-warning" href="<?= url('admin/index.php?page=gallery&action=view&id=' . (int) $album['id']); ?>">Open</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
