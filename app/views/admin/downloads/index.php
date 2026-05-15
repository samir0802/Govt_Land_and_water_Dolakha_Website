<?php require __DIR__ . '/../partials/header.php'; ?>
<?php require __DIR__ . '/../partials/sidebar.php'; ?>
<main class="col-lg-10 p-4 bg-light">
    <h1 class="h3 mb-3">Downloads Manager</h1>
    <div class="card mb-4"><div class="card-body">
        <form method="POST" enctype="multipart/form-data" action="<?= url('admin/index.php?page=downloads&action=create'); ?>" class="row g-3">
            <div class="col-md-6"><input name="title_np" required class="form-control" placeholder="Title NP"></div>
            <div class="col-md-6"><input name="title_en" class="form-control" placeholder="Title EN"></div>
            <div class="col-md-4"><input type="datetime-local" name="published_at" class="form-control"></div>
            <div class="col-md-8"><input type="file" name="document" required accept="application/pdf" class="form-control"></div>
            <div class="col-12"><button class="btn btn-primary">Upload Document</button></div>
        </form>
    </div></div>
    <table class="table table-striped">
        <?php foreach ($downloads as $item): ?>
            <tr><td><?= e($item['title_np']); ?></td><td><a href="<?= asset($item['file_path']); ?>" target="_blank">Open</a></td>
            <td><form method="POST" action="<?= url('admin/index.php?page=downloads&action=delete&id=' . (int) $item['id']); ?>"><button class="btn btn-sm btn-danger">Delete</button></form></td></tr>
        <?php endforeach; ?>
    </table>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
