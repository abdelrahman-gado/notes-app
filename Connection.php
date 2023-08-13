<?php

class Connection
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO("mysql:host=localhost;dbname=notes", "root", "");
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getNotes(): array
    {
        $sql = "SELECT * FROM notes ORDER BY create_date DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addNote(array $note): void
    {
        $sql = "INSERT INTO notes (title, description, create_date) VALUES 
            (:title, :description, :create_date)";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue('title', $note['title']);
        $stmt->bindValue('description', $note['description']);
        $stmt->bindValue('create_date', date('Y-m-d H:i:s'));

        $stmt->execute();
    }

    public function getNoteById(int $id): array
    {
        $sql = "SELECT * FROM notes WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue('id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function updateNote(int $id, array $note): void
    {
        $sql = "UPDATE notes SET title = :title, description = :description WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue('title', $note['title']);
        $stmt->bindValue('description', $note['description']);
        $stmt->bindValue('id', $id);

        $stmt->execute();
    }

    public function deleteNote($id): void
    {
        $sql = "DELETE FROM notes WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue('id', $id);

        $stmt->execute();
    }

}


return new Connection();