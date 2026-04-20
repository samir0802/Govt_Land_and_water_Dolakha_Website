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

}
