<?php

declare(strict_types=1);

class Employee extends BaseModel
{
    public function all(): array
    {
        return $this->db->query('SELECT * FROM employees ORDER BY sort_order ASC, id DESC')->fetchAll();
    }

    public function create(array $payload): void
    {
        $stmt = $this->db->prepare(
            'INSERT INTO employees (name_np, name_en, designation_np, designation_en, photo_path, sort_order) VALUES (:name_np, :name_en, :designation_np, :designation_en, :photo_path, :sort_order)'
        );
        $stmt->execute($payload);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM employees WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM employees WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row ?: null;
    }
}
