<?php

declare(strict_types=1);

require_once __DIR__ . '/../models/Gallery.php';
require_once __DIR__ . '/../models/Setting.php';

class GalleryController extends BaseController
{
    private Gallery $galleryModel;
    private Setting $settingModel;

    public function __construct(array $config, PDO $db)
    {
        parent::__construct($config);
        $this->galleryModel = new Gallery($db);
        $this->settingModel = new Setting($db);
    }

    public function index(): void
    {
        $albumId = isset($_GET['album']) ? (int) $_GET['album'] : null;
        $siteSettings = $this->settingModel->all();
        $viewConfig = $this->config;
        if (!empty($siteSettings['site_name_np'])) {
            $viewConfig['app']['name_np'] = $siteSettings['site_name_np'];
        }
        if (!empty($siteSettings['site_name_en'])) {
            $viewConfig['app']['name_en'] = $siteSettings['site_name_en'];
        }

        if ($albumId) {
            $album = $this->galleryModel->getAlbum($albumId);
            if (!$album) {
                redirect($this->config['app']['base_url']);
            }

            $this->view('pages/gallery_album', [
                'config' => $viewConfig,
                'album' => $album,
                'mediaItems' => $this->galleryModel->albumMedia($albumId),
            ]);
            return;
        }

        $this->view('pages/gallery', [
            'config' => $viewConfig,
            'albums' => $this->galleryModel->allAlbums(),
        ]);
    }
}
