<?php

require "app/helpers.php";
require "app/models/Post.php";

$host = "localhost";
$username = "root";
$password = "";
$dbname = "blog";

$db = new PDO("mysql:host=localhost;dbname=$dbname", $username, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (!isset($_GET['id'])) {
    http_response_code(404);
    echo '404';
    die;
}

$post_id = $_GET['id'];

$post = new Post($db);
$post->delete($post_id);

header('Location: ' . $_SERVER['HTTP_REFERER']);
