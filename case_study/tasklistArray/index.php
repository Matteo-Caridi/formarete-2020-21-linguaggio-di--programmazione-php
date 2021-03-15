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
if (isset($_GET['searchText']) && (trim($_GET['searchText']) !== '')) {
    $searchText = trim(filter_var($_GET['searchText'], FILTER_SANITIZE_STRING));
    $taskList = array_filter($taskList, searchText($searchText));
} elseif (isset($_GET['status']) && (isset($_GET['status']) !== '')) {
    $status = $_GET['status'];
    $taskList = array_filter($taskList, searchStatus($status));
} elseif (isset($_GET['expireDate']) && (trim($_GET['expireDate']) !== '')) {
    $expire = $_GET['expireDate'];
    $taskList = array_filter($taskList, searchDate($expire));
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

        <input type="text" value="" name="searchText" placeholder="Inserire cosa cercare">
        <input type="text" value="" name="expireDate" placeholder="Inserire data scadenza">
        <button type="submit">Cerca</button>
        <div id="status">

            <input type="radio" name="status" value="progress" id="progress" <?php if(isset($_GET['status']) && $_GET['status'] =='progress'){echo "checked";};?>>
            <label for="progress">Progress</label>

            <input type="radio" name="status" value="done" id="done" <?php if(isset($_GET['status']) && $_GET['status'] =='done'){echo "checked";};?>>
            <label for="done">Done</label>

            <input type="radio" name="status" value="todo" id="todo" <?php if(isset($_GET['status']) && $_GET['status'] =='todo'){echo "checked";};?>>
            <label for="todo">To do</label>

            <input type="radio" name="status" value="all" id="all" <?php if(isset($_GET['status']) && $_GET['status'] =='all'){echo "checked";};?>>
            <label for="all">Tutto</label>
        </div>
    </form>

    <ul>
        <?php foreach ($taskList as $task) {

            $taskName = $task['taskName'];
            $status = $task['status'];
            $expireDate = $task['expirationDate'];
        ?>
            <li class="tasklist-item tasklist-item-<?= $status ?>">

                <?= $taskName ?>
                <?= '|' ?>
                <?= $status ?>
                <?= '|' ?>
                <?= $expireDate ?>
            </li>
        <?php } ?>
    </ul>



</body>

</html>