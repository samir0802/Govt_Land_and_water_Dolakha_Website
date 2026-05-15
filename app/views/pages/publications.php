<?php require __DIR__ . '/../partials/header.php'; ?>
<main class="container py-5">
    <h1 class="section-title">प्रकाशन</h1>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead><tr><th>शीर्षक</th><th>मिति</th></tr></thead>
            <tbody>
            <?php foreach ($publications as $item): ?>
                <tr>
                    <td>
                        <h2 class="h6 mb-1"><strong><?= e($item['title_np']); ?></strong></h2>
                        <p class="mb-0 small"><?= e(substr($item['summary_np'] ?? '', 0, 200)); ?></p>
                    </td>
                    <td style="width: 140px;"><?= date('Y-m-d', strtotime($item['published_at'])); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
