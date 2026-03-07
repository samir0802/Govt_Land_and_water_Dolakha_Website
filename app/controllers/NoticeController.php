<?php

declare(strict_types=1);

require_once __DIR__ . '/../models/Notice.php';

class NoticeController extends BaseController
{
    private Notice $noticeModel;

    public function __construct(array $config, PDO $db)
    {
        parent::__construct($config);
        $this->noticeModel = new Notice($db);
    }

    public function index(): void
    {
        $this->view('pages/notices', [
            'config' => $this->config,
            'notices' => $this->noticeModel->all(),
        ]);
    }
}
