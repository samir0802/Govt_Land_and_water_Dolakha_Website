<?php

declare(strict_types=1);

class Notice extends BaseModel
{
    public function latest(int $limit = 5): array
    {
        $stmt = $this->db->prepare('SELECT * FROM notices ORDER BY published_at DESC LIMIT :limit');
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function all(): array
    {
        return $this->db->query('SELECT * FROM notices ORDER BY published_at DESC')->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM notices WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $notice = $stmt->fetch();

        return $notice ?: null;
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare('INSERT INTO notices (title_np, title_en, content_np, content_en, published_at) VALUES (:title_np, :title_en, :content_np, :content_en, :published_at)');

        return $stmt->execute($data);
    }

    public function update(int $id, array $data): bool
    {
        $data['id'] = $id;
        $stmt = $this->db->prepare('UPDATE notices SET title_np = :title_np, title_en = :title_en, content_np = :content_np, content_en = :content_en, published_at = :published_at, updated_at = CURRENT_TIMESTAMP WHERE id = :id');

        return $stmt->execute($data);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM notices WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }
}
