<?php

declare(strict_types=1);

class Publication extends BaseModel
{
    public function latest(int $limit = 6): array
    {
        $stmt = $this->db->prepare('SELECT * FROM publications ORDER BY published_at DESC LIMIT :limit');
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function all(): array
    {
        return $this->db->query('SELECT * FROM publications ORDER BY published_at DESC')->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM publications WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $publication = $stmt->fetch();

        return $publication ?: null;
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare('INSERT INTO publications (title_np, title_en, summary_np, summary_en, published_at) VALUES (:title_np, :title_en, :summary_np, :summary_en, :published_at)');

        return $stmt->execute($data);
    }

    public function update(int $id, array $data): bool
    {
        $data['id'] = $id;
        $stmt = $this->db->prepare('UPDATE publications SET title_np = :title_np, title_en = :title_en, summary_np = :summary_np, summary_en = :summary_en, published_at = :published_at, updated_at = CURRENT_TIMESTAMP WHERE id = :id');

        return $stmt->execute($data);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM publications WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }
}
