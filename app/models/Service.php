<?php

declare(strict_types=1);

class Service extends BaseModel
{
    public function all(): array
    {
        return $this->db->query('SELECT * FROM services ORDER BY sort_order ASC, id DESC')->fetchAll();
    }
}
