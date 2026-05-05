<?php require __DIR__ . '/../partials/header.php'; ?>

<main>
    <section class="hero-section">
        <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active"><img src="<?= asset('images/uploads/hero/slide1.svg'); ?>" class="d-block w-100 hero-image" alt="कार्यालय भवन"></div>
                <div class="carousel-item"><img src="<?= asset('images/uploads/hero/slide2.svg'); ?>" class="d-block w-100 hero-image" alt="सेवा प्रवाह"></div>
            </div>
        </div>
    </section>

    <section class="container py-5" id="notices">
        <h2 class="section-title"><?= lang() === 'en' ? 'Latest Notices' : 'ताजा सूचना'; ?></h2>
        <div class="row g-3">
            <?php foreach ($latestNotices as $notice): ?>
                <div class="col-md-6">
                    <article class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h3 class="h5"><?= e(trField($notice, 'title')); ?></h3>
                            <p class="small text-muted mb-2"><?= e(date('Y-m-d', strtotime($notice['published_at']))); ?></p>
                            <p class="mb-0"><?= e(mb_strimwidth(trField($notice, 'content'), 0, 180, '...')); ?></p>
                        </div>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="bg-light py-5" id="introduction">
        <div class="container">
            <h2 class="section-title"><?= lang() === 'en' ? 'Office Introduction' : 'कार्यालय परिचय'; ?></h2>
            <p>खानेपानी, सिंचाइ तथा जलस्रोत कार्यालय, दोलखाले जिल्लाभर सुरक्षित खानेपानी, साना सिंचाइ आयोजना, र जलस्रोत व्यवस्थापन सम्बन्धी सेवा प्रदान गर्दछ।</p>
        </div>
    </section>

    <section class="container py-5" id="services">
        <h2 class="section-title"><?= lang() === 'en' ? 'Our Services' : 'हाम्रा सेवाहरू'; ?></h2>
        <div class="row g-3">
            <?php foreach ($services as $service): ?>
                <div class="col-md-4"><div class="card h-100"><div class="card-body"><h3 class="h6"><?= e(trField($service, 'title')); ?></h3><p class="mb-0"><?= e(trField($service, 'description')); ?></p></div></div></div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="bg-light py-5" id="publications">
        <div class="container">
            <h2 class="section-title"><?= lang() === 'en' ? 'Publications' : 'प्रकाशन'; ?></h2>
            <ul class="list-group">
                <?php foreach ($publications as $item): ?>
                    <li class="list-group-item d-flex justify-content-between"><span><?= e(trField($item, 'title')); ?></span><small><?= e(date('Y-m-d', strtotime($item['published_at']))); ?></small></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>

    <section class="container py-5" id="downloads">
        <h2 class="section-title"><?= lang() === 'en' ? 'Downloads' : 'डाउनलोड'; ?></h2>
        <div class="row g-3">
            <?php foreach ($downloads as $download): ?>
                <div class="col-md-4"><a class="card card-body text-decoration-none" href="<?= asset('images/' . ltrim($download['file_path'], '/')); ?>" target="_blank"><?= e($download['title_np']); ?></a></div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="container py-5" id="gallery">
        <div class="d-flex justify-content-between align-items-center mb-3"><h2 class="section-title mb-0">ग्यालरी फोल्डरहरू</h2><a href="<?= url('public/index.php?page=gallery'); ?>">सबै फोल्डर हेर्नुहोस्</a></div>
        <div class="row g-3">
            <?php foreach ($gallery as $album): ?>
                <div class="col-6 col-md-4">
                    <a class="card h-100 text-decoration-none" href="<?= url('public/index.php?page=gallery&album=' . (int) $album['id']); ?>">
                        <?php if (!empty($album['cover_image'])): ?><img src="<?= asset('images/' . ltrim($album['cover_image'], '/')); ?>" alt="<?= e($album['title_np']); ?>" class="img-fluid rounded shadow-sm gallery-thumb"><?php endif; ?>
                        <div class="mt-2"><?= e($album['title_np']); ?></div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="bg-light py-5" id="contact">
        <div class="container">
            <h2 class="section-title">सम्पर्क</h2>
            <p>ठेगाना: <?= e(setting('office_address', 'चरिकोट, दोलखा') ?? 'चरिकोट, दोलखा'); ?> | फोन: <?= e(setting('office_phone', '०४९-४२००००') ?? '०४९-४२००००'); ?> | इमेल: <?= e(setting('office_email', 'info@dolakhaoffice.gov.np') ?? 'info@dolakhaoffice.gov.np'); ?></p>
        </div>
    </section>
</main>

<?php require __DIR__ . '/../partials/footer.php'; ?>
