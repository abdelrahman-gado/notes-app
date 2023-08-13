<?php

$connection = require_once __DIR__ . "/Connection.php";

$notes = $connection->getNotes();

$currentNote = [
    'id' => '',
    'title' => '',
    'description' => ''
];

if (isset($_GET['id'])) 
{
    $noteId = (int) $_GET['id'];
    $currentNote = $connection->getNoteById($noteId);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="app.css">
    <title>Notes App</title>
</head>

<body>
    <form class="new-note" action="save.php" method="POST">
        <input type="hidden" name="id" value="<?= $currentNote['id'] ?>">
        <input type="text" name="title" placeholder="Note title" value="<?= $currentNote['title'] ?>" autocomplete="off">
        <textarea name="description" cols="30" rows="4" placeholder="Note Description"><?= $currentNote['description'] ?></textarea>
        <button>
            <?php if ($currentNote['id']): ?>
                Update Note
            <?php else: ?>
                New Note
            <?php endif; ?>
        </button>
    </form>

    <div class="notes">
        <?php foreach($notes as $note): ?>
            <div class="note">
            <div class="title">
                <a href="index.php?id=<?= $note['id'] ?>"><?= $note['title'] ?></a>
            </div>
            <div class="description">
                <?= $note['description'] ?>
            </div>
            <small><?= $note['create_date'] ?></small>
            <button class="close" data-id="<?= $note['id'] ?>">X</button>
        </div>
        <?php endforeach; ?>
    </div>

    <script>
        const deleteButtons = document.querySelectorAll('.close');
        deleteButtons.forEach((button) => {
            button.addEventListener('click', (e) => {
                const id = e.target.dataset['id'];
                let formData = new FormData();
                formData.append('id', id);

                const p = fetch('/delete.php', {
                    method: 'POST',
                    body: formData
                });

                p.then((res) => {
                    button.parentElement.remove();
                }).catch((err) => {
                    console.log(err);
                });
            });
        })
    </script>
</body>

</html>