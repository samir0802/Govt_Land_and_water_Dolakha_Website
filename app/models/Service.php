<?php

declare(strict_types=1);

class Service extends BaseModel
{
    public function all(): array
    {
        return $this->db->query('SELECT * FROM services ORDER BY sort_order ASC, id DESC')->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM services WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public function create(array $payload): void
    {
        $stmt = $this->db->prepare(
            'INSERT INTO services (title_np, title_en, description_np, description_en, sort_order)
             VALUES (:title_np, :title_en, :description_np, :description_en, :sort_order)'
        );
        $stmt->execute($payload);
    }

    public function update(int $id, array $payload): void
    {
        $payload['id'] = $id;
        $stmt = $this->db->prepare(
            'UPDATE services SET
                title_np = :title_np,
                title_en = :title_en,
                description_np = :description_np,
                description_en = :description_en,
                sort_order = :sort_order
            WHERE id = :id'
        );
        $stmt->execute($payload);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM services WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}
