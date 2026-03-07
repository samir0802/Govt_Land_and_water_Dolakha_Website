<?php require __DIR__ . '/../partials/header.php'; ?>
<main class="container py-5">
    <h1 class="section-title">सूचना तथा समाचार</h1>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead><tr><th>शीर्षक</th><th>मिति</th></tr></thead>
            <tbody>
            <?php foreach ($notices as $notice): ?>
                <tr>
                    <td>
                        <h2 class="h6 mb-1"><?= e($notice['title_np']); ?></h2>
                        <p class="mb-0 small"><?= e($notice['content_np']); ?></p>
                    </td>
                    <td><?= e(date('Y-m-d', strtotime($notice['published_at']))); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
