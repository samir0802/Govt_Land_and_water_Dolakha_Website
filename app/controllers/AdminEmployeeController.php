<?php

declare(strict_types=1);

require_once __DIR__ . '/../models/Employee.php';

class AdminEmployeeController extends BaseController
{
    private Employee $employeeModel;

    public function __construct(array $config, PDO $db)
    {
        parent::__construct($config);
        $this->employeeModel = new Employee($db);
    }

    public function index(): void
    {
        $this->view('admin/employees/index', [
            'config' => $this->config,
            'employees' => $this->employeeModel->all(),
        ]);
    }

    public function create(): void
    {
        $photoPath = null;

        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $upload = $_FILES['photo'];
            $mime = mime_content_type($upload['tmp_name']);
            if (!in_array($mime, ['image/jpeg', 'image/png'], true)) {
                $_SESSION['admin_error'] = 'Employee photo must be JPG or PNG.';
                redirect($this->config['app']['base_url'] . 'admin/index.php?page=employees');
            }

            $ext = $mime === 'image/png' ? 'png' : 'jpg';
            $dir = __DIR__ . '/../../public/assets/images/uploads/employees';
            if (!is_dir($dir)) {
                mkdir($dir, 0775, true);
            }

            $filename = date('YmdHis') . '-' . bin2hex(random_bytes(4)) . '.' . $ext;
            move_uploaded_file($upload['tmp_name'], $dir . '/' . $filename);
            $photoPath = '/assets/images/uploads/employees/' . $filename;
        }

        $this->employeeModel->create([
            'name_np' => trim($_POST['name_np'] ?? ''),
            'name_en' => trim($_POST['name_en'] ?? ''),
            'designation_np' => trim($_POST['designation_np'] ?? ''),
            'designation_en' => trim($_POST['designation_en'] ?? ''),
            'photo_path' => $photoPath,
            'sort_order' => (int) ($_POST['sort_order'] ?? 0),
        ]);

        $_SESSION['admin_success'] = 'Employee added successfully.';
        redirect($this->config['app']['base_url'] . 'admin/index.php?page=employees');
    }

    public function delete(int $id): void
    {
        $employee = $this->employeeModel->find($id);
        if ($employee && !empty($employee['photo_path'])) {
            $file = __DIR__ . '/../../public' . $employee['photo_path'];
            if (is_file($file)) {
                unlink($file);
            }
        }

        $this->employeeModel->delete($id);
        $_SESSION['admin_success'] = 'Employee removed successfully.';
        redirect($this->config['app']['base_url'] . 'admin/index.php?page=employees');
    }
}
