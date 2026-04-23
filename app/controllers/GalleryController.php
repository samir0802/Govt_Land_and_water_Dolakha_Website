<?php

declare(strict_types=1);

require_once __DIR__ . '/../models/Gallery.php';

class GalleryController extends BaseController
{
    private Gallery $galleryModel;

    public function __construct(array $config, PDO $db)
    {
        parent::__construct($config);
        $this->galleryModel = new Gallery($db);
    }

    public function index(): void
    {
        $albumId = isset($_GET['album']) ? (int) $_GET['album'] : null;

        if ($albumId) {
            $album = $this->galleryModel->getAlbum($albumId);
            if (!$album) {
                redirect($this->config['app']['base_url']);
            }

            $this->view('pages/gallery_album', [
                'config' => $this->config,
                'album' => $album,
                'mediaItems' => $this->galleryModel->albumMedia($albumId),
            ]);
            return;
        }

        $this->view('pages/gallery', [
            'config' => $this->config,
            'albums' => $this->galleryModel->allAlbums(),
        ]);
    }
}
