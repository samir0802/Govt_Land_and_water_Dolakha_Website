<?php

declare(strict_types=1);

require_once __DIR__ . '/../models/Setting.php';

class AdminSettingController extends BaseController
{
    private Setting $settingModel;

    private array $managedKeys = [
        'site_name_np',
        'site_name_en',
        'office_address',
        'office_phone',
        'office_email',
        'facebook_url',
        'youtube_url',
        'notice_items_limit',
        'maintenance_mode',
    ];

    public function __construct(array $config, PDO $db)
    {
        parent::__construct($config);
        $this->settingModel = new Setting($db);
    }

    public function index(): void
    {
        $this->view('admin/settings/index', [
            'config' => $this->config,
            'settings' => $this->settingModel->all(),
        ]);
    }

    public function save(): void
    {
        foreach ($this->managedKeys as $key) {
            $value = trim((string) ($_POST[$key] ?? ''));
            $this->settingModel->upsert($key, $value);
        }

        $_SESSION['admin_success'] = 'Settings saved successfully.';
        redirect($this->config['app']['base_url'] . 'admin/index.php?page=settings');
    }
}
