<?php require __DIR__ . '/../partials/header.php'; ?>
<?php require __DIR__ . '/../partials/sidebar.php'; ?>
<main class="col-lg-10 p-4 bg-light">
    <h1 class="h3 mb-3">Publications Manager</h1>

    <?php if (!empty($_SESSION['admin_success'])): ?>
        <div class="alert alert-success"><?= e($_SESSION['admin_success']); ?></div>
        <?php unset($_SESSION['admin_success']); ?>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-body">
            <form method="POST" action="<?= url('admin/index.php?page=publications&action=create'); ?>" class="row g-3">
                <div class="col-md-6"><input name="title_np" class="form-control" placeholder="Title (Nepali)" required></div>
                <div class="col-md-6"><input name="title_en" class="form-control" placeholder="Title (English)"></div>
                <div class="col-md-6"><textarea name="summary_np" class="form-control" rows="3" placeholder="Summary (Nepali)"></textarea></div>
                <div class="col-md-6"><textarea name="summary_en" class="form-control" rows="3" placeholder="Summary (English)"></textarea></div>
                <div class="col-md-4"><input type="datetime-local" name="published_at" class="form-control"></div>
                <div class="col-12"><button class="btn btn-primary">Save Publication</button></div>
            </form>
        </div>
    </div>

    <table class="table table-striped">
        <thead><tr><th>Title</th><th>Published</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($publications as $item): ?>
            <tr>
                <td><?= e($item['title_np']); ?></td>
                <td><?= e(date('Y-m-d', strtotime($item['published_at']))); ?></td>
                <td>
                    <form method="POST" action="<?= url('admin/index.php?page=publications&action=delete&id=' . (int) $item['id']); ?>" onsubmit="return confirm('Delete this publication?');">
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
