<?php

class Post
{
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getPage($page_number, $per_page)
    {
        $offset = ($page_number - 1) * $per_page;
        $sql = "
SELECT id, title, author_name, posted_at, image_name, content FROM posts
ORDER BY posted_at DESC LIMIT $per_page OFFSET $offset ;";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAll()
    {
        $sql = "SELECT COUNT(*) AS cnt FROM posts ;";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['cnt'];
    }

    public function get($id)
    {
        $sql = "
SELECT id, title, author_name, posted_at, image_name, content FROM posts
WHERE id = :id ;";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);        
        $stmt->execute();
        $row = null;
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return $row;
    }

    public function delete($id)
    {
        
        $sq="DELETE FROM posts WHERE id=:id";
        $stmt = $this->db->prepare($sq);
        $stmt->bindParam(':id', $id);        
        $stmt->execute();
        
        
    }


    public function edit($id, $title, $author_name, $content)
    {
        $sql="UPDATE posts SET title=:title , author_name=:author_name ,content=:content WHERE id=:id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':author_name', $author_name);
        $stmt->bindParam(':title', $title);
        $stmt->execute();
    }
}
