<?php
// config.php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'crud_php';


$base_url = '/';

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die('Erro ao conectar ao banco de dados: ' . mysqli_connect_error());
}

mysqli_set_charset($conn, 'utf8'); 