<?php

declare(strict_types=1);

class Publication extends BaseModel
{
    public function all(): array
    {
        return $this->db->query('SELECT * FROM publications ORDER BY published_at DESC, id DESC')->fetchAll();
    }

    public function latest(int $limit = 6): array
    {
        $stmt = $this->db->prepare('SELECT * FROM publications ORDER BY published_at DESC LIMIT :limit');
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function create(array $payload): void
    {
        $stmt = $this->db->prepare(
            'INSERT INTO publications (title_np, title_en, summary_np, summary_en, published_at)
             VALUES (:title_np, :title_en, :summary_np, :summary_en, :published_at)'
        );
        $stmt->execute($payload);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM publications WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}
