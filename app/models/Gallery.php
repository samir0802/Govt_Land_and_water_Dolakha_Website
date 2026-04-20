<?php

declare(strict_types=1);

class Gallery extends BaseModel
{
    public function latest(int $limit = 8): array
    {
        $stmt = $this->db->prepare('SELECT * FROM gallery ORDER BY id DESC LIMIT :limit');
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function all(): array
    {
        return $this->db->query('SELECT * FROM gallery ORDER BY id DESC')->fetchAll();
    }

}
