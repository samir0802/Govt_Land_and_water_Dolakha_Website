<?php require __DIR__ . '/../partials/header.php'; ?>

<main>
    <section class="hero-section">
        <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active"><img src="<?= asset('images/uploads/hero/slide3.svg'); ?>" class="d-block w-100 hero-image" alt="कार्यालय भवन"></div>
                <div class="carousel-item"><img src="<?= asset('images/uploads/hero/slide4.svg'); ?>" class="d-block w-100 hero-image" alt="सेवा प्रवाह"></div>
            </div>
        </div>
    </section>

    <section class="container py-5" id="notices">
        <h2 class="section-title">सूचना</h2>
        <div class="row g-3">
            <?php foreach ($latestNotices as $notice): ?>
                <div class="col-md-6">
                    <article class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h3 class="h5"><?= e($notice['title_np']); ?></h3>
                            <p class="small text-muted mb-2"><?= e(date('Y-m-d', strtotime($notice['published_at']))); ?></p>
                            <p class="mb-0"><?= e(mb_strimwidth($notice['content_np'], 0, 180, '...')); ?></p>
                        </div>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="bg-light py-5" id="introduction">
        <div class="container">
            <h2 class="section-title">कार्यालय परिचय</h2>
            <p>खानेपानी, सिँचाइ तथा जलस्रोत कार्यालय, दोलखा बागमती प्रदेश सरकार, ऊर्जा, जलस्रोत तथा सिँचाइ मन्त्रालय अन्तर्गतको एक प्रमुख निकाय हो। यस कार्यालयले दोलखा जिल्लाभर सुरक्षित खानेपानीको पहुँच विस्तार, कृषि उत्पादन वृद्धिका लागि भरपर्दो सिँचाइ प्रणालीको विकास र जलस्रोतको दिगो व्यवस्थापनमा महत्वपूर्ण भूमिका खेल्दै आएको छ।

दोलखा जिल्लाको भौगोलिक विशिष्टतालाई मध्यनजर गर्दै यस कार्यालयले साना तथा मझौला सिँचाइ आयोजनाहरू, खानेपानीका मुहान संरक्षण, र नदी नियन्त्रणका कार्यहरूलाई प्राथमिकताका साथ अगाडि बढाएको छ। स्थानीय जनसहभागिता र उपभोक्ता समितिहरूसँगको समन्वयमा आयोजनाहरू कार्यान्वयन गरी जिल्लाको सामाजिक तथा आर्थिक रूपान्तरणमा टेवा पुर्‍याउनु यस कार्यालयको मुख्य ध्येय रहेको छ।

मुख्य उद्देश्यहरू:
जिल्लाका प्रत्येक नागरिकलाई स्वच्छ र गुणस्तरीय खानेपानी सेवा उपलब्ध गराउन योजनाहरू तर्जुमा र कार्यान्वयन गर्ने।

आधुनिक तथा दिगो सिँचाइ पूर्वाधारहरूको निर्माण गरी कृषि क्षेत्रको उत्पादकत्व वृद्धिमा सहयोग पुर्‍याउने।

जलउत्पन्न प्रकोप (बाढी, पहिरो) नियन्त्रणका लागि तटबन्ध र अन्य संरक्षणका कार्यहरू सञ्चालन गर्ने।

स्थानीय जलस्रोतको पहिचान, संरक्षण र बहुआयामिक उपयोगलाई प्रवर्द्धन गर्ने।

सेवा प्रवाहमा पारदर्शिता, उत्तरदायित्व र सुशासन कायम गर्दै नागरिकलाई सहज प्राविधिक सेवा प्रदान गर्ने।

हामी प्रविधिको उच्चतम प्रयोग र स्थानीय स्रोत-साधनको प्रभावकारी परिचालनमार्फत "समृद्ध बागमती प्रदेश" को लक्ष्य प्राप्तिका लागि निरन्तर क्रियाशील छौँ।</p>
        </div>
    </section>

    <section class="container py-5" id="services">
        <h2 class="section-title">हाम्रा सेवाहरू</h2>
        <div class="row g-3">
            <?php foreach ($services as $service): ?>
                <div class="col-md-4"><div class="card h-100"><div class="card-body"><h3 class="h6"><?= e($service['title_np']); ?></h3><p class="mb-0"><?= e($service['description_np']); ?></p></div></div></div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="bg-light py-5" id="publications">
        <div class="container">
            <h2 class="section-title">प्रकाशन</h2>
            <ul class="list-group">
                <?php foreach ($publications as $item): ?>
                    <li class="list-group-item d-flex justify-content-between"><span><?= e($item['title_np']); ?></span><small><?= e(date('Y-m-d', strtotime($item['published_at']))); ?></small></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>

    <section class="container py-5" id="downloads">
        <h2 class="section-title">डाउनलोड</h2>
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
