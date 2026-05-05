<?php require __DIR__ . '/../partials/header.php'; ?>
<?php require __DIR__ . '/../partials/sidebar.php'; ?>
<main class="col-lg-10 p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Notices Manager</h1>
        <a href="<?= url('admin/index.php?page=notices&action=create'); ?>" class="btn btn-primary">Add Notice</a>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead><tr><th>Title</th><th>Date</th><th>Actions</th></tr></thead>
            <tbody>
            <?php foreach ($notices as $notice): ?>
                <tr>
                    <td><?= e($notice['title_np']); ?></td>
                    <td><?= e(date('Y-m-d', strtotime($notice['published_at']))); ?></td>
                    <td class="d-flex gap-2">
                        <a class="btn btn-sm btn-warning" href="<?= url('admin/index.php?page=notices&action=edit&id=' . (int) $notice['id']); ?>">Edit</a>
                        <form method="post" action="<?= url('admin/index.php?page=notices&action=delete&id=' . (int) $notice['id']); ?>" onsubmit="return confirm('Delete this notice?')">
                            <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
