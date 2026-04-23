<?php

declare(strict_types=1);

require_once __DIR__ . '/../models/Notice.php';
require_once __DIR__ . '/../models/Service.php';
require_once __DIR__ . '/../models/Publication.php';
require_once __DIR__ . '/../models/Download.php';
require_once __DIR__ . '/../models/Gallery.php';
require_once __DIR__ . '/../models/Setting.php';

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
        $settingModel = new Setting($this->db);

        $siteSettings = $settingModel->all();
        $viewConfig = $this->config;
        if (!empty($siteSettings['site_name_np'])) {
            $viewConfig['app']['name_np'] = $siteSettings['site_name_np'];
        }
        if (!empty($siteSettings['site_name_en'])) {
            $viewConfig['app']['name_en'] = $siteSettings['site_name_en'];
        }

        $this->view('pages/home', [
            'config' => $viewConfig,
            'latestNotices' => $noticeModel->latest(6),
            'services' => $serviceModel->all(),
            'publications' => $publicationModel->latest(6),
            'downloads' => $downloadModel->latest(6),
            'gallery' => $galleryModel->latest(6),
            'siteSettings' => $siteSettings,
        ]);
    }
}
