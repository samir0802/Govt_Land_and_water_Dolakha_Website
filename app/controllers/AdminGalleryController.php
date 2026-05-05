<?php

declare(strict_types=1);

require_once __DIR__ . '/../models/Gallery.php';

class AdminGalleryController extends BaseController
{
    private Gallery $galleryModel;

    public function __construct(array $config, PDO $db)
    {
        parent::__construct($config);
        $this->galleryModel = new Gallery($db);
    }

    public function index(): void
    {
        $this->view('admin/gallery/index', [
            'config' => $this->config,
            'albums' => $this->galleryModel->allAlbums(),
        ]);
    }

    public function createAlbum(): void
    {
        if (!$this->galleryModel->supportsAlbums()) {
            $_SESSION['admin_error'] = 'Gallery album tables are not available. Please run the latest database schema.';
            redirect('admin/index.php?page=gallery');
        }

        $titleNp = trim($_POST['title_np'] ?? '');
        if ($titleNp === '') {
            $_SESSION['admin_error'] = 'Album title is required.';
            redirect('admin/index.php?page=gallery');
        }

        $albumId = $this->galleryModel->createAlbum([
            'title_np' => $titleNp,
            'title_en' => trim($_POST['title_en'] ?? ''),
            'event_date' => $_POST['event_date'] ?: null,
        ]);

        $this->handleMediaUploads($albumId);

        $_SESSION['admin_success'] = 'Gallery album created successfully.';
        redirect('admin/index.php?page=gallery');
    }

    public function viewAlbum(int $id): void
    {
        if (!$this->galleryModel->supportsAlbums()) {
            $_SESSION['admin_error'] = 'Gallery album tables are not available. Please run the latest database schema.';
            redirect('admin/index.php?page=gallery');
        }

        $album = $this->galleryModel->getAlbum($id);
        if (!$album) {
            $_SESSION['admin_error'] = 'Album not found.';
            redirect('admin/index.php?page=gallery');
        }

        $this->view('admin/gallery/album', [
            'config' => $this->config,
            'album' => $album,
            'mediaItems' => $this->galleryModel->albumMedia($id),
        ]);
    }

    public function uploadMedia(int $id): void
    {
        if (!$this->galleryModel->supportsAlbums()) {
            $_SESSION['admin_error'] = 'Gallery album tables are not available. Please run the latest database schema.';
            redirect('admin/index.php?page=gallery');
        }

        $album = $this->galleryModel->getAlbum($id);
        if (!$album) {
            $_SESSION['admin_error'] = 'Album not found.';
            redirect('admin/index.php?page=gallery');
        }

        $this->handleMediaUploads($id);
        $_SESSION['admin_success'] = 'Media uploaded to album.';
        redirect('admin/index.php?page=gallery&action=view&id=' . $id);
    }

    public function deleteAlbum(int $id): void
    {
        if (!$this->galleryModel->supportsAlbums()) {
            $_SESSION['admin_error'] = 'Gallery album tables are not available. Please run the latest database schema.';
            redirect('admin/index.php?page=gallery');
        }

        $mediaItems = $this->galleryModel->albumMedia($id);
        foreach ($mediaItems as $item) {
            $path = __DIR__ . '/../../public/assets/images/' . ltrim($item['image_path'], '/');
            if (is_file($path)) {
                unlink($path);
            }
        }

        $this->galleryModel->deleteAlbum($id);
        $_SESSION['admin_success'] = 'Album deleted.';
        redirect('admin/index.php?page=gallery');
    }

    private function handleMediaUploads(int $albumId): void
    {
        if (!isset($_FILES['media_files'])) {
            return;
        }

        $allowedTypes = [
            'image/jpeg' => ['folder' => 'images', 'ext' => 'jpg', 'type' => 'image'],
            'image/png' => ['folder' => 'images', 'ext' => 'png', 'type' => 'image'],
            'video/mp4' => ['folder' => 'videos', 'ext' => 'mp4', 'type' => 'video'],
            'video/webm' => ['folder' => 'videos', 'ext' => 'webm', 'type' => 'video'],
            'video/quicktime' => ['folder' => 'videos', 'ext' => 'mov', 'type' => 'video'],
        ];

        $names = $_FILES['media_files']['name'];
        $tmpNames = $_FILES['media_files']['tmp_name'];
        $errors = $_FILES['media_files']['error'];

        for ($i = 0, $count = count($names); $i < $count; $i++) {
            if ($errors[$i] !== UPLOAD_ERR_OK) {
                continue;
            }

            $mime = mime_content_type($tmpNames[$i]);
            if (!isset($allowedTypes[$mime])) {
                continue;
            }

            $meta = $allowedTypes[$mime];
            $dir = __DIR__ . '/../../public/assets/images/uploads/gallery/' . $albumId . '/' . $meta['folder'];
            if (!is_dir($dir)) {
                mkdir($dir, 0775, true);
            }

            $filename = date('YmdHis') . '-' . $i . '-' . bin2hex(random_bytes(3)) . '.' . $meta['ext'];
            move_uploaded_file($tmpNames[$i], $dir . '/' . $filename);

            $this->galleryModel->addItem([
                'album_id' => $albumId,
                'media_type' => $meta['type'],
                'image_path' => 'uploads/gallery/' . $albumId . '/' . $meta['folder'] . '/' . $filename,
            ]);
        }
    }
}
