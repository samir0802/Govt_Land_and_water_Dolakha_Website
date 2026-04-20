<?php

declare(strict_types=1);

require_once __DIR__ . '/../models/Service.php';
require_once __DIR__ . '/../models/Publication.php';
require_once __DIR__ . '/../models/Download.php';
require_once __DIR__ . '/../models/Gallery.php';

class PageController extends BaseController
{
    private PDO $db;

    public function __construct(array $config, PDO $db)
    {
        parent::__construct($config);
        $this->db = $db;
    }

    public function introduction(): void
    {
        $this->view('pages/introduction', ['config' => $this->config]);
    }

    public function services(): void
    {
        $serviceModel = new Service($this->db);
        $this->view('pages/services', [
            'config' => $this->config,
            'services' => $serviceModel->all(),
        ]);
    }

    public function publications(): void
    {
        $publicationModel = new Publication($this->db);
        $this->view('pages/publications', [
            'config' => $this->config,
            'publications' => $publicationModel->all(),
        ]);
    }

    public function downloads(): void
    {
        $downloadModel = new Download($this->db);
        $this->view('pages/downloads', [
            'config' => $this->config,
            'downloads' => $downloadModel->all(),
        ]);
    }

    public function gallery(): void
    {
        $galleryModel = new Gallery($this->db);
        $this->view('pages/gallery', [
            'config' => $this->config,
            'gallery' => $galleryModel->all(),
        ]);
    }

    public function contact(): void
    {
        $this->view('pages/contact', ['config' => $this->config]);
    }
}
