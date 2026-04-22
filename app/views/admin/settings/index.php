<?php require __DIR__ . '/../partials/header.php'; ?>
<?php require __DIR__ . '/../partials/sidebar.php'; ?>
<main class="col-lg-10 p-4 bg-light">
    <h1 class="h3 mb-3">Website Settings</h1>

    <?php if (!empty($_SESSION['admin_success'])): ?><div class="alert alert-success"><?= e($_SESSION['admin_success']); ?></div><?php unset($_SESSION['admin_success']); endif; ?>

    <div class="card">
        <div class="card-header">Admin controls</div>
        <div class="card-body">
            <form method="POST" action="<?= $config['app']['base_url'] ?>admin/index.php?page=settings&action=save" class="row g-3">
                <div class="col-md-6"><label class="form-label">Site Name (Nepali)</label><input name="site_name_np" value="<?= e($settings['site_name_np'] ?? $config['app']['name_np']); ?>" class="form-control"></div>
                <div class="col-md-6"><label class="form-label">Site Name (English)</label><input name="site_name_en" value="<?= e($settings['site_name_en'] ?? $config['app']['name_en']); ?>" class="form-control"></div>
                <div class="col-md-6"><label class="form-label">Office Address</label><input name="office_address" value="<?= e($settings['office_address'] ?? ''); ?>" class="form-control"></div>
                <div class="col-md-3"><label class="form-label">Office Phone</label><input name="office_phone" value="<?= e($settings['office_phone'] ?? ''); ?>" class="form-control"></div>
                <div class="col-md-3"><label class="form-label">Office Email</label><input type="email" name="office_email" value="<?= e($settings['office_email'] ?? ''); ?>" class="form-control"></div>
                <div class="col-md-6"><label class="form-label">Facebook URL</label><input name="facebook_url" value="<?= e($settings['facebook_url'] ?? ''); ?>" class="form-control"></div>
                <div class="col-md-6"><label class="form-label">YouTube URL</label><input name="youtube_url" value="<?= e($settings['youtube_url'] ?? ''); ?>" class="form-control"></div>
                <div class="col-md-4"><label class="form-label">Homepage Notice Limit</label><input type="number" min="1" max="20" name="notice_items_limit" value="<?= e($settings['notice_items_limit'] ?? '6'); ?>" class="form-control"></div>
                <div class="col-md-4"><label class="form-label">Maintenance Mode</label><select name="maintenance_mode" class="form-select"><option value="0" <?= (($settings['maintenance_mode'] ?? '0') === '0') ? 'selected' : ''; ?>>Disabled</option><option value="1" <?= (($settings['maintenance_mode'] ?? '0') === '1') ? 'selected' : ''; ?>>Enabled</option></select></div>
                <div class="col-12"><button class="btn btn-primary">Save Settings</button></div>
            </form>
        </div>
    </div>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
