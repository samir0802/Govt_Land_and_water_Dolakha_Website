<?php require __DIR__ . '/../partials/header.php'; ?>
<main class="container py-5">
    <h1 class="section-title">सम्पर्क</h1>
    <div class="row g-4">
        <div class="col-md-6">
            <h2 class="h5">कार्यालय ठेगाना</h2>
            <p class="mb-1">खानेपानी, सिंचाइ तथा जलस्रोत कार्यालय, दोलखा</p>
            <p class="mb-1">चरिकोट, दोलखा</p>
            <p class="mb-1">फोन: ०४९-४२००००</p>
            <p class="mb-0">इमेल: info@dolakhaoffice.gov.np</p>
        </div>
        <div class="col-md-6">
            <h2 class="h5">नागरिक सन्देश</h2>
            <form>
                <div class="mb-3"><label class="form-label">नाम</label><input class="form-control" placeholder="तपाईंको नाम"></div>
                <div class="mb-3"><label class="form-label">इमेल</label><input type="email" class="form-control" placeholder="example@mail.com"></div>
                <div class="mb-3"><label class="form-label">सन्देश</label><textarea class="form-control" rows="4"></textarea></div>
                <button type="button" class="btn btn-primary" disabled>Send (CMS integration pending)</button>
            </form>
        </div>
    </div>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
