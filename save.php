<?php

$connection = require_once __DIR__ . "/Connection.php";


$id = $_POST['id'] ?? '';
if ($id === '') {
    $connection->addNote($_POST);
} else {
    $connection->updateNote($id, $_POST);
}

header('Location: index.php');