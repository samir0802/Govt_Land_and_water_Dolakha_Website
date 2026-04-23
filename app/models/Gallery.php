<?php

declare(strict_types=1);

class Gallery extends BaseModel
{
    public function latest(int $limit = 8): array
    {
        if ($this->hasAlbumsTables()) {
            $stmt = $this->db->prepare(
                'SELECT ga.id, ga.title_np, ga.title_en, MIN(gm.media_path) AS cover_image
                 FROM gallery_albums ga
                 LEFT JOIN gallery_media gm ON gm.album_id = ga.id AND gm.media_type = "image"
                 GROUP BY ga.id, ga.title_np, ga.title_en
                 ORDER BY ga.id DESC
                 LIMIT :limit'
            );
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll();
        }

        $stmt = $this->db->prepare('SELECT id, title_np, title_en, image_path AS cover_image FROM gallery ORDER BY id DESC LIMIT :limit');
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function allAlbums(): array
    {
        if ($this->hasAlbumsTables()) {
            return $this->db->query(
                'SELECT ga.*, COUNT(gm.id) AS total_items
                 FROM gallery_albums ga
                 LEFT JOIN gallery_media gm ON gm.album_id = ga.id
                 GROUP BY ga.id
                 ORDER BY ga.event_date DESC, ga.id DESC'
            )->fetchAll();
        }

        return $this->db->query(
            'SELECT id, title_np, title_en, NULL AS event_date, 1 AS total_items FROM gallery ORDER BY id DESC'
        )->fetchAll();
    }

    public function supportsAlbums(): bool
    {
        return $this->hasAlbumsTables();
    }

    public function createAlbum(array $payload): int
    {
        $stmt = $this->db->prepare('INSERT INTO gallery_albums (title_np, title_en, event_date) VALUES (:title_np, :title_en, :event_date)');
        $stmt->execute($payload);

        return (int) $this->db->lastInsertId();
    }

    public function addMedia(array $payload): void
    {
        $stmt = $this->db->prepare(
            'INSERT INTO gallery_media (album_id, media_type, media_path) VALUES (:album_id, :media_type, :media_path)'
        );
        $stmt->execute($payload);
    }

    public function getAlbum(int $id): ?array
    {
        if ($this->hasAlbumsTables()) {
            $stmt = $this->db->prepare('SELECT * FROM gallery_albums WHERE id = :id LIMIT 1');
            $stmt->execute(['id' => $id]);
            $row = $stmt->fetch();

            return $row ?: null;
        }

        $stmt = $this->db->prepare('SELECT id, title_np, title_en, NULL AS event_date FROM gallery WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public function albumMedia(int $albumId): array
    {
        if ($this->hasAlbumsTables()) {
            $stmt = $this->db->prepare('SELECT * FROM gallery_media WHERE album_id = :album_id ORDER BY id DESC');
            $stmt->execute(['album_id' => $albumId]);

            return $stmt->fetchAll();
        }

        $stmt = $this->db->prepare('SELECT id, id AS album_id, "image" AS media_type, image_path AS media_path FROM gallery WHERE id = :id');
        $stmt->execute(['id' => $albumId]);

        return $stmt->fetchAll();
    }

    public function deleteAlbum(int $id): void
    {
        if (!$this->hasAlbumsTables()) {
            return;
        }

        $stmt = $this->db->prepare('DELETE FROM gallery_albums WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }

    private function hasAlbumsTables(): bool
    {
        return $this->tableExists('gallery_albums') && $this->tableExists('gallery_media');
    }

    private function tableExists(string $table): bool
    {
        $stmt = $this->db->prepare('SHOW TABLES LIKE :table_name');
        $stmt->execute(['table_name' => $table]);

        return (bool) $stmt->fetchColumn();
    }
}
