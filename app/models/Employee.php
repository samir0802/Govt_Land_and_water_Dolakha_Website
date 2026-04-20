<?php

declare(strict_types=1);

class Employee extends BaseModel
{
    public function all(): array
    {
        return $this->db->query('SELECT * FROM employees ORDER BY sort_order ASC, id DESC')->fetchAll();
    }
}
