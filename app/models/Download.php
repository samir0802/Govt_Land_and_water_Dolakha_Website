<?php

declare(strict_types=1);

class Download extends BaseModel
{
    public function all(): array
    {
        return $this->db->query('SELECT * FROM downloads ORDER BY published_at DESC, id DESC')->fetchAll();
    }

    public function latest(int $limit = 6): array
    {
        $stmt = $this->db->prepare('SELECT * FROM downloads ORDER BY published_at DESC LIMIT :limit');
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function create(array $payload): void
    {
        $stmt = $this->db->prepare(
            'INSERT INTO downloads (title_np, title_en, file_path, file_type, published_at) VALUES (:title_np, :title_en, :file_path, :file_type, :published_at)'
        );
        $stmt->execute($payload);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM downloads WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM downloads WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row ?: null;
    }
}
