<?php require __DIR__ . '/../partials/header.php'; ?>
<?php require __DIR__ . '/../partials/sidebar.php'; ?>
<main class="col-lg-10 p-4 bg-light">
    <h1 class="h3 mb-3">Downloads Manager</h1>

    <?php if (!empty($_SESSION['admin_success'])): ?>
        <div class="alert alert-success"><?= e($_SESSION['admin_success']); ?></div>
        <?php unset($_SESSION['admin_success']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['admin_error'])): ?>
        <div class="alert alert-danger"><?= e($_SESSION['admin_error']); ?></div>
        <?php unset($_SESSION['admin_error']); ?>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header">Upload document (PDF)</div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data" action="<?= $config['app']['base_url'] ?>admin/index.php?page=downloads&action=create" class="row g-3">
                <div class="col-md-6"><label class="form-label">Title (Nepali)</label><input name="title_np" required class="form-control"></div>
                <div class="col-md-6"><label class="form-label">Title (English)</label><input name="title_en" class="form-control"></div>
                <div class="col-md-4"><label class="form-label">Published At</label><input type="datetime-local" name="published_at" class="form-control"></div>
                <div class="col-md-8"><label class="form-label">PDF File</label><input type="file" name="document" required accept="application/pdf" class="form-control"></div>
                <div class="col-12"><button class="btn btn-primary">Upload Document</button></div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Available public downloads</div>
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead><tr><th>Title</th><th>File</th><th>Published</th><th class="text-end">Action</th></tr></thead>
                <tbody>
                <?php foreach ($downloads as $item): ?>
                    <tr>
                        <td><?= e($item['title_np']); ?></td>
                        <td><a href="<?= e($item['file_path']); ?>" target="_blank">Open PDF</a></td>
                        <td><?= e(date('Y-m-d', strtotime($item['published_at']))); ?></td>
                        <td class="text-end">
                            <form method="POST" action="<?= $config['app']['base_url'] ?>admin/index.php?page=downloads&action=delete&id=<?= (int) $item['id']; ?>" onsubmit="return confirm('Delete this file?');">
                                <button class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
