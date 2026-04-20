<?php require __DIR__ . '/../partials/header.php'; ?>
<?php require __DIR__ . '/../partials/sidebar.php'; ?>
<?php
$generatedHash = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $passwordInput = trim($_POST['password_to_hash'] ?? '');
    if ($passwordInput !== '') {
        $generatedHash = password_hash($passwordInput, PASSWORD_DEFAULT);
    }
}
?>
<main class="col-lg-10 p-4 bg-light">
    <h1 class="h3 mb-3">Settings</h1>
    <p class="text-muted">Generate secure password hashes for SQL seed updates or manual user insert scripts.</p>

    <div class="card">
        <div class="card-body">
            <h2 class="h5">Password Hash Generator</h2>
            <form method="post" action="<?= url('admin/index.php?page=settings'); ?>" class="row g-3">
                <div class="col-md-8">
                    <label class="form-label">Plain Password</label>
                    <input type="text" name="password_to_hash" class="form-control" placeholder="Enter password to hash" required>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Generate Hash</button>
                </div>
            </form>

            <?php if ($generatedHash): ?>
                <div class="mt-3">
                    <label class="form-label">Generated Hash</label>
                    <textarea class="form-control" rows="3" readonly><?= e($generatedHash); ?></textarea>
                </div>
            <?php endif; ?>

            <p class="small text-muted mt-3 mb-0">Tip: Prefer generating fresh hashes over hardcoding a shared default hash in production.</p>
        </div>
    </div>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
