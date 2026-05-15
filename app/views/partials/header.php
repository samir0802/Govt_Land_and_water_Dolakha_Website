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
    
    <div class="d-flex align-items-center gap-3">
        <img src="<?= asset('images/Emblem_of_Nepal.svg'); ?>" alt="नेपाल सरकारको लोगो" class="emblem">
        <div>
            <p class="mb-0 fw-bold">बागमती प्रदेश सरकार</p>
            <p class="mb-0 fw-bold"><?= e(setting('site_name_np', $config['app']['name_np']) ?? $config['app']['name_np']); ?></p>
            <p class="mb-0 fw-bold"><?= e(setting('office_address', 'चरिकोट, दोलखा') ?? 'चरिकोट, दोलखा'); ?></p>
        </div>        
        <img src="<?= asset('images/topbg_CUCDohGKGe.png'); ?>" alt="header_background" class="background-img" >
        <div class="ms-auto align-items-left">
            <p class="mb-0"><strong>फोन:</strong> <?= e(setting('office_phone', '०१-४२०००००') ?? '०१-४२०००००'); ?></p>
            <p class="mb-0"><strong>इमेल:</strong> <a href="mailto:<?= e(setting('office_email', 'info@example.gov.np') ?? 'info@example.gov.np'); ?>"><?= e(setting('office_email', 'info@example.gov.np') ?? 'info@example.gov.np'); ?></a></p>
        </div>
        
    </div>
</header>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
    <div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="<?= url('public/index.php'); ?>">गृहपृष्ठ</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= url('public/index.php?page=introduction'); ?>">परिचय</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= url('public/index.php?page=services'); ?>">सेवा</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= url('public/index.php?page=notices'); ?>">सूचना</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= url('public/index.php?page=publications'); ?>">प्रकाशन</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= url('public/index.php?page=downloads'); ?>">डाउनलोड</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= url('public/index.php?page=gallery'); ?>">ग्यालरी</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= url('public/index.php?page=contact'); ?>">सम्पर्क</a></li>
            </ul>
            
        </div>
        
    </div>
</nav>
