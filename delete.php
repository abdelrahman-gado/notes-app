<?php

$connection = require_once __DIR__ . "/Connection.php";

$id = $_POST['id'] ?? false;

if ($id) {
    $connection->deleteNote($id);
}

return;