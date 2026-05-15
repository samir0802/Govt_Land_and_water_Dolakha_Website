<?php require __DIR__ . '/../partials/header.php'; ?>
<main class="container py-5">
    <h1 class="section-title">सम्पर्क</h1>
    <div class="card shadow-sm"><div class="card-body">
        <p><strong>ठेगाना:</strong> <?= e(setting('office_address', 'चरिकोट, दोलखा') ?? 'चरिकोट, दोलखा'); ?></p>
        <p><strong>फोन:</strong> <?= e(setting('office_phone', '०४९-४२००००') ?? '०४९-४२००००'); ?></p>
        <p><strong>इमेल:</strong> <?= e(setting('office_email', 'info@dolakhaoffice.gov.np') ?? 'info@dolakhaoffice.gov.np'); ?></p>
        <p><strong>फेसबुक:</strong> <?= e(setting('facebook_url', 'info@dolakhaoffice.gov.np') ?? 'info@dolakhaoffice.gov.np'); ?></p>
        <p><strong>यूट्युब:</strong> <?= e(setting('youtube_url', 'info@dolakhaoffice.gov.np') ?? 'info@dolakhaoffice.gov.np'); ?></p>
        <p><strong>कार्यालय समय:</strong> आइतबार–शुक्रबार, बिहान १०:०० देखि साँझ ५:००</p>
    </div></div>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
