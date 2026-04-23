<!doctype html>
<html lang="ne">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e(setting('site_name_np', $config['app']['name_np']) ?? $config['app']['name_np']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('css/style.css'); ?>">
</head>
<body>
<header class="gov-header py-3 border-bottom">
    <div class="container d-flex align-items-center gap-3">
        <img src="<?= asset('images/nepal-emblem.svg'); ?>" alt="नेपाल सरकारको लोगो" class="emblem">
        <div>
            <p class="mb-0 fw-bold">नेपाल सरकार</p>
            <p class="mb-0"><?= e(setting('site_name_np', $config['app']['name_np']) ?? $config['app']['name_np']); ?></p>
            <p class="mb-0"><?= e(setting('office_address', 'सिंहदरबार, काठमाडौं') ?? 'सिंहदरबार, काठमाडौं'); ?></p>
        </div>
    </div>
</header>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
    <div class="container">
        <a class="navbar-brand" href="<?= url('public/index.php'); ?>">कार्यालय</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="<?= url('public/index.php'); ?>">गृहपृष्ठ</a></li>
                <li class="nav-item"><a class="nav-link" href="#introduction">परिचय</a></li>
                <li class="nav-item"><a class="nav-link" href="#services">सेवा</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= url('public/index.php?page=notices'); ?>">सूचना</a></li>
                <li class="nav-item"><a class="nav-link" href="#publications">प्रकाशन</a></li>
                <li class="nav-item"><a class="nav-link" href="#downloads">डाउनलोड</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= url('public/index.php?page=gallery'); ?>">ग्यालरी</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact">सम्पर्क</a></li>
            </ul>
        </div>
    </div>
</nav>
