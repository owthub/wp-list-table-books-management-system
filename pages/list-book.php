<?php

if(!class_exists("BooksListTable")){

    include_once BMS_PLUGIN_PATH . 'class/BooksListTable.php';
}

$bookListTableObject = new BooksListTable();

echo "<h1>List Books</h1>";

// To run all logics
$bookListTableObject->prepare_items();

?>

<form id="frm_serch" method="get">

   <input type="hidden" name="page" value="list-books">

   <?php 

       // To add search box
       $bookListTableObject->search_box("Search Books", "search_books");

       // To display table
       $bookListTableObject->display();

   ?>

</form>