<?php

declare(strict_types=1);

require_once __DIR__ . '/../models/Service.php';

class AdminServiceController extends BaseController
{
    private Service $serviceModel;

    public function __construct(array $config, PDO $db)
    {
        parent::__construct($config);
        $this->serviceModel = new Service($db);
    }

    public function index(): void
    {
        $this->view('admin/services/index', [
            'config' => $this->config,
            'services' => $this->serviceModel->all(),
            'editService' => null,
        ]);
    }

    public function editForm(int $id): void
    {
        $this->view('admin/services/index', [
            'config' => $this->config,
            'services' => $this->serviceModel->all(),
            'editService' => $this->serviceModel->find($id),
        ]);
    }

    public function create(): void
    {
        $this->serviceModel->create([
            'title_np' => trim((string) ($_POST['title_np'] ?? '')),
            'title_en' => trim((string) ($_POST['title_en'] ?? '')),
            'description_np' => trim((string) ($_POST['description_np'] ?? '')),
            'description_en' => trim((string) ($_POST['description_en'] ?? '')),
            'sort_order' => (int) ($_POST['sort_order'] ?? 0),
        ]);

        $_SESSION['admin_success'] = 'Service created successfully.';
        redirect('admin/index.php?page=services');
    }

    public function update(int $id): void
    {
        $this->serviceModel->update($id, [
            'title_np' => trim((string) ($_POST['title_np'] ?? '')),
            'title_en' => trim((string) ($_POST['title_en'] ?? '')),
            'description_np' => trim((string) ($_POST['description_np'] ?? '')),
            'description_en' => trim((string) ($_POST['description_en'] ?? '')),
            'sort_order' => (int) ($_POST['sort_order'] ?? 0),
        ]);

        $_SESSION['admin_success'] = 'Service updated successfully.';
        redirect('admin/index.php?page=services');
    }

    public function delete(int $id): void
    {
        $this->serviceModel->delete($id);
        $_SESSION['admin_success'] = 'Service deleted successfully.';
        redirect('admin/index.php?page=services');
    }
}
