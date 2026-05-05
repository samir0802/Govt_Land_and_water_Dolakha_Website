<?php

declare(strict_types=1);

require_once __DIR__ . '/../models/Publication.php';

class AdminPublicationController extends BaseController
{
    private Publication $publicationModel;

    public function __construct(array $config, PDO $db)
    {
        parent::__construct($config);
        $this->publicationModel = new Publication($db);
    }

    public function index(): void
    {
        $this->view('admin/publications/index', [
            'config' => $this->config,
            'publications' => $this->publicationModel->all(),
        ]);
    }

    public function create(): void
    {
        $this->publicationModel->create([
            'title_np' => trim((string) ($_POST['title_np'] ?? '')),
            'title_en' => trim((string) ($_POST['title_en'] ?? '')),
            'summary_np' => trim((string) ($_POST['summary_np'] ?? '')),
            'summary_en' => trim((string) ($_POST['summary_en'] ?? '')),
            'published_at' => $_POST['published_at'] ?: date('Y-m-d H:i:s'),
        ]);

        $_SESSION['admin_success'] = 'Publication created successfully.';
        redirect('admin/index.php?page=publications');
    }

    public function delete(int $id): void
    {
        $this->publicationModel->delete($id);
        $_SESSION['admin_success'] = 'Publication deleted successfully.';
        redirect('admin/index.php?page=publications');
    }
}
