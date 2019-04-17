<?php
/**
 * Show off the autoloader.
 */
include(__DIR__ . "/autoload.php");
include(__DIR__ . "/config.php");
include(__DIR__ . "/view/header.php");

// If there isnt any session create a new object
if (!isset($_SESSION["guess"])) {
    $_SESSION["guess"] = new Guess();
}
$guess = $_SESSION["guess"];

// Prints and include of form
echo "<p>Make a guess between 1 and 100.</p>";
echo "<H1>You have " , $guess->tries() , ($guess->tries() == 1) ? " try" : " tries" , " left.</h1>";
include(__DIR__ . "/view/form.php");
if (isset($_SESSION["result"])) {
    echo "<p>" . $_SESSION["result"] . "</p>";
}

include(__DIR__ . "/view/footer.php");
