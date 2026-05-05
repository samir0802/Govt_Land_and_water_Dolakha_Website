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
        $data = $this->commonData();
        $this->view('pages/home', $data);
    }

    public function introduction(): void
    {
        $this->view('pages/introduction', [
            'config' => $this->config,
        ]);
    }

    public function services(): void
    {
        $this->view('pages/services', [
            'config' => $this->config,
            'services' => (new Service($this->db))->all(),
        ]);
    }

    public function publications(): void
    {
        $this->view('pages/publications', [
            'config' => $this->config,
            'publications' => (new Publication($this->db))->latest(50),
        ]);
    }

    public function downloads(): void
    {
        $this->view('pages/downloads', [
            'config' => $this->config,
            'downloads' => (new Download($this->db))->all(),
        ]);
    }

    public function contact(): void
    {
        $this->view('pages/contact', [
            'config' => $this->config,
        ]);
    }

    private function commonData(): array
    {
        $noticeModel = new Notice($this->db);
        $serviceModel = new Service($this->db);
        $publicationModel = new Publication($this->db);
        $downloadModel = new Download($this->db);
        $galleryModel = new Gallery($this->db);

        return [
            'config' => $this->config,
            'latestNotices' => $noticeModel->latest(6),
            'services' => $serviceModel->all(),
            'publications' => $publicationModel->latest(6),
            'downloads' => $downloadModel->latest(6),
            'gallery' => $galleryModel->latest(6),
        ];
    }
}
