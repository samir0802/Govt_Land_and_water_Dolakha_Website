<?php

declare(strict_types=1);

require_once __DIR__ . '/../models/Notice.php';

class AdminNoticeController extends BaseController
{
    private Notice $noticeModel;

    public function __construct(array $config, PDO $db)
    {
        parent::__construct($config);
        $this->noticeModel = new Notice($db);
    }

    public function index(): void
    {
        $this->view('admin/notices/index', [
            'config' => $this->config,
            'notices' => $this->noticeModel->all(),
        ]);
    }

    public function createForm(): void
    {
        $this->view('admin/notices/form', ['config' => $this->config, 'notice' => null]);
    }

    public function create(): void
    {
        $payload = [
            'title_np' => trim($_POST['title_np'] ?? ''),
            'title_en' => trim($_POST['title_en'] ?? ''),
            'content_np' => trim($_POST['content_np'] ?? ''),
            'content_en' => trim($_POST['content_en'] ?? ''),
            'published_at' => $_POST['published_at'] ?: date('Y-m-d H:i:s'),
        ];
        $this->noticeModel->create($payload);
        redirect(url('admin/index.php?page=notices'));
    }

    public function editForm(int $id): void
    {
        $this->view('admin/notices/form', [
            'config' => $this->config,
            'notice' => $this->noticeModel->find($id),
        ]);
    }

    public function update(int $id): void
    {
        $payload = [
            'title_np' => trim($_POST['title_np'] ?? ''),
            'title_en' => trim($_POST['title_en'] ?? ''),
            'content_np' => trim($_POST['content_np'] ?? ''),
            'content_en' => trim($_POST['content_en'] ?? ''),
            'published_at' => $_POST['published_at'] ?: date('Y-m-d H:i:s'),
        ];
        $this->noticeModel->update($id, $payload);
        redirect(url('admin/index.php?page=notices'));
    }

    public function delete(int $id): void
    {
        $this->noticeModel->delete($id);
        redirect(url('admin/index.php?page=notices'));
    }
}
