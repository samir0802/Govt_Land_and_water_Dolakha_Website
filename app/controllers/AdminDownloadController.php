<?php

declare(strict_types=1);

require_once __DIR__ . '/../models/Download.php';

class AdminDownloadController extends BaseController
{
    private Download $downloadModel;

    public function __construct(array $config, PDO $db)
    {
        parent::__construct($config);
        $this->downloadModel = new Download($db);
    }

    public function index(): void
    {
        $this->view('admin/downloads/index', [
            'config' => $this->config,
            'downloads' => $this->downloadModel->all(),
        ]);
    }

    public function create(): void
    {
        if (!isset($_FILES['document']) || $_FILES['document']['error'] !== UPLOAD_ERR_OK) {
            $_SESSION['admin_error'] = 'Please upload a valid PDF file.';
            redirect('admin/index.php?page=downloads');
        }

        $upload = $_FILES['document'];
        $mime = mime_content_type($upload['tmp_name']);
        if ($mime !== 'application/pdf') {
            $_SESSION['admin_error'] = 'Only PDF documents are allowed in downloads.';
            redirect('admin/index.php?page=downloads');
        }

        $dir = __DIR__ . '/../../public/assets/images/uploads/downloads';
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        $filename = date('YmdHis') . '-' . bin2hex(random_bytes(4)) . '.pdf';
        $destination = $dir . '/' . $filename;
        move_uploaded_file($upload['tmp_name'], $destination);

        $publishedAtInput = trim((string) ($_POST['published_at'] ?? ''));
        $publishedAt = $publishedAtInput !== '' ? date('Y-m-d H:i:s', strtotime($publishedAtInput)) : date('Y-m-d H:i:s');

        $this->downloadModel->create([
            'title_np' => trim($_POST['title_np'] ?? ''),
            'title_en' => trim($_POST['title_en'] ?? ''),
            'file_path' => 'uploads/downloads/' . $filename,
            'file_type' => 'application/pdf',
            'published_at' => $publishedAt,
        ]);

        $_SESSION['admin_success'] = 'Download file uploaded successfully.';
        redirect('admin/index.php?page=downloads');
    }

    public function delete(int $id): void
    {
        $download = $this->downloadModel->find($id);
        if ($download && isset($download['file_path'])) {
            $file = __DIR__ . '/../../public/assets/images/' . ltrim($download['file_path'], '/');
            if (is_file($file)) {
                unlink($file);
            }
        }
        $this->downloadModel->delete($id);
        $_SESSION['admin_success'] = 'Download removed successfully.';
        redirect('admin/index.php?page=downloads');
    }
}
