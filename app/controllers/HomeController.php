<?php

declare(strict_types=1);

require_once __DIR__ . '/../models/Notice.php';
require_once __DIR__ . '/../models/Service.php';
require_once __DIR__ . '/../models/Publication.php';
require_once __DIR__ . '/../models/Download.php';
require_once __DIR__ . '/../models/Gallery.php';

class HomeController extends BaseController
{
    private PDO $db;

    public function __construct(array $config, PDO $db)
    {
        parent::__construct($config);
        $this->db = $db;
    }

    public function index(): void
    {
        $noticeModel = new Notice($this->db);
        $serviceModel = new Service($this->db);
        $publicationModel = new Publication($this->db);
        $downloadModel = new Download($this->db);
        $galleryModel = new Gallery($this->db);

        $this->view('pages/home', [
            'config' => $this->config,
            'latestNotices' => $noticeModel->latest(6),
            'services' => $serviceModel->all(),
            'publications' => $publicationModel->latest(6),
            'downloads' => $downloadModel->latest(6),
            'gallery' => $galleryModel->latest(6),
        ]);
    }
}
