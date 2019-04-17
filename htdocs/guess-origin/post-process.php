<?php
include(__DIR__ . "/autoload.php");
include(__DIR__ . "/config.php");

$guess = $_SESSION["guess"];

if (isset($_POST["reset"])) { // Delete session if the reset button is pressed
    sessionDestroy();
} elseif (isset($_POST["make"])) { // if Make guess button is pressed
    try {
        $_SESSION["result"] = $guess->makeGuess($_POST["guess"]);
    } catch (GuessException $e) {
        $_SESSION["result"] = "Needs to be an integer between 1 and 100.";
    }
} elseif (isset($_POST["cheat"])) { // if cheat button is pressed
    $_SESSION["result"] = "The secret number is " . $guess->number();
}

// Redirect to a result page.
$url = "index.php";
header("Location: $url");
