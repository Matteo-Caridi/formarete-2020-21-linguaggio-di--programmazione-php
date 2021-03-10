<?php

// carichiamo le dipendenze (sono quello che serve per elaborare lo script finale)

require './lib/JSONReader.php';
require './lib/searchFunctions.php';
// Model
// e' la parte che gestisce i dati dell'applicazione non per forza dati statici.
$taskList = JSONReader('./dataset/TaskList.json');

// controller è la parte che si occupa di gestire le due parti cioè la vista e il model
// prendo dei dati, una volta che abbiamo questi dati, come verranno passati alla vista? con quale
// criterio?  se ne occupa il controller.
// il controller è quello che capisce che è stato premuto il + ...
// il controller passa i dati filtrati alla vista (view)
// $data = JSONReader() 
if (isset($_GET['searchText'])) {
    $searchText = trim(filter_var($_GET['searchText'], FILTER_SANITIZE_STRING));
    $taskList = array_filter($taskList, searchText($searchText));
} else {
    $searchText = "";
}
?>



<!-- View (vista) parte di visualizzazione e che intercetta le azioni dell'utente -->
<!-- vuol dire che abbiamo un layout ma quando l'utente scrive qualcosa per cercare -->
<!-- sta interagendo con la vista che è sia la parte del programma che si occupa di rappresentare -->
<!-- l'applicazione, i dati ecc. e la parte che si occupa anche di intercettare le azioni dell'utente -->
<!-- la vista prende ciò che l'utente scrive e se ne occupa lui -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task List</title>
    <link rel="stylesheet" href="./asset/style.css">

</head>

<body>
    <form action="./index.php">

        <input type="text" value="<?= $searchText ?>" name="searchText">
        <button type="submit">Cerca</button>
    </form>

    <ul>
        <?php
        foreach ($taskList as $task) {
            $status = $task['status'];
            $taskName = $task['taskName'];
        ?>
            <li class="tastklist-item tasklist-item-<?= $status ?>">
                <?= $taskName ?>
                <b><?= $status ?></b>
            </li>
        <?php } ?>

    </ul>
</body>

</html>