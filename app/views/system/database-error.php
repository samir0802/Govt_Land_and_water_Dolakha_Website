<!doctype html>
<html lang="ne">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Setup Required</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('css/style.css'); ?>">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4 p-lg-5">
                    <span class="badge text-bg-warning mb-3">Setup Required</span>
                    <h1 class="h3 mb-3">Database connection is not ready yet.</h1>
                    <p class="mb-3">The application could not open the configured MySQL database. It attempted to create the database automatically when the database name was missing, but MySQL credentials or server permissions may still need attention.</p>
                    <div class="alert alert-secondary">
                        <strong>Configured database:</strong> <?= e($config['db']['database']); ?><br>
                        <strong>Host:</strong> <?= e($config['db']['host']); ?>:<?= e($config['db']['port']); ?>
                    </div>
                    <h2 class="h5 mt-4">How to fix</h2>
                    <ol class="mb-4">
                        <li>Create the MySQL database manually if your hosting provider does not allow PHP to create it automatically.</li>
                        <li>Import the schema from <code>database/schema.sql</code>.</li>
                        <li>Update <code>config/config.php</code> or your environment variables with the correct DB credentials.</li>
                        <li>Refresh this page after setup.</li>
                    </ol>
                    <?php if ($dbError instanceof Throwable): ?>
                        <details>
                            <summary class="fw-semibold">Technical details</summary>
                            <pre class="mt-3 p-3 bg-dark text-light rounded small mb-0"><?= e($dbError->getMessage()); ?></pre>
                        </details>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
