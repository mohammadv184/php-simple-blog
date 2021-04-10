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
        // TODO: Implement getPage method here
    }

    public function countAll()
    {
        // TODO: Implement countAll method here
    }

    public function get($id)
    {
        // TODO: Implement get method here
    }
}
