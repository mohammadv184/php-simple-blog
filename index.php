<?php

require "app/helpers.php";
require "app/models/Post.php";

$host = "localhost";
$username = "root";
$password = "";
$dbname = "blog";

$db = new PDO("mysql:host=localhost;dbname=$dbname", $username, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$page_number = $_GET['page'] ?? 1;
$per_page = 6;

$post = new Post($db);
$posts = $post->getPage($page_number, $per_page);

include "app/templates/index.tpl";
