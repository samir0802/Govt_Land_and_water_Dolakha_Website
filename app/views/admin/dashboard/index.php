<?php require __DIR__ . '/../partials/header.php'; ?>
<?php require __DIR__ . '/../partials/sidebar.php'; ?>
<main class="col-lg-10 p-4 bg-light">
    <h1 class="h3 mb-4">Dashboard Overview</h1>
    <div class="row g-3">
        <div class="col-md-3">
            <div class="card card-body">
                <strong>Notices</strong>
                <span><?= (int) ($stats['notices'] ?? 0); ?> total notices</span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-body">
                <strong>Downloads</strong>
                <span><?= (int) ($stats['downloads'] ?? 0); ?> uploaded files</span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-body">
                <strong>Employees</strong>
                <span><?= (int) ($stats['employees'] ?? 0); ?> staff profiles</span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-body">
                <strong>Gallery</strong>
                <span><?= (int) ($stats['gallery_albums'] ?? 0); ?> folders/albums</span>
            </div>
        </div>
    </div>
    <p class="text-muted mt-3 mb-0">Counts update automatically when you add/delete records from other admin tabs.</p>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
