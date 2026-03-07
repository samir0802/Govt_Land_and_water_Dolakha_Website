<?php

declare(strict_types=1);

class Download extends BaseModel
{
    public function latest(int $limit = 6): array
    {
        $stmt = $this->db->prepare('SELECT * FROM downloads ORDER BY published_at DESC LIMIT :limit');
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
