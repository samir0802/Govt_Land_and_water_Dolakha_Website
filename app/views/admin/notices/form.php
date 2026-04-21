<?php require __DIR__ . '/../partials/header.php'; ?>
<?php require __DIR__ . '/../partials/sidebar.php'; ?>
<main class="col-lg-10 p-4">
    <?php $isEdit = !empty($notice); ?>
    <h1 class="h3 mb-3"><?= $isEdit ? 'Edit Notice' : 'Add Notice'; ?></h1>
    <form method="post" action="<?= $config['app']['base_url'] ?>admin/index.php?page=notices&action=<?= $isEdit ? 'update&id=' . (int) $notice['id'] : 'create'; ?>">
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label">Title (Nepali)</label><input class="form-control" name="title_np" value="<?= e($notice['title_np'] ?? ''); ?>" required></div>
            <div class="col-md-6"><label class="form-label">Title (English)</label><input class="form-control" name="title_en" value="<?= e($notice['title_en'] ?? ''); ?>"></div>
            <div class="col-md-6"><label class="form-label">Content (Nepali)</label><textarea class="form-control" name="content_np" rows="5" required><?= e($notice['content_np'] ?? ''); ?></textarea></div>
            <div class="col-md-6"><label class="form-label">Content (English)</label><textarea class="form-control" name="content_en" rows="5"><?= e($notice['content_en'] ?? ''); ?></textarea></div>
            <div class="col-md-4"><label class="form-label">Published At</label><input type="datetime-local" class="form-control" name="published_at" value="<?= !empty($notice['published_at']) ? date('Y-m-d\TH:i', strtotime($notice['published_at'])) : ''; ?>"></div>
        </div>
        <div class="mt-3"><button type="submit" class="btn btn-success">Save</button><a href="<?= $config['app']['base_url'] ?>admin/index.php?page=notices" class="btn btn-secondary">Back</a></div>
    </form>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
