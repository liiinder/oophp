<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));


/**
 * Init the game and redirect to play the game.
 */
$app->router->get("guess/init", function () use ($app) {
    // Init the game
    $game = new Linder\Guess\Guess();
    $_SESSION["number"] = $game->number();
    $_SESSION["tries"] = $game->tries();
    unset($_SESSION["res"]);

    return $app->response->redirect("guess/play");
});

/**
* Play the game.
 */
$app->router->get("guess/play", function () use ($app) {
    $title = "Gissa numret";
    
    // Deal with session variables
    if(!isset($_SESSION["number"])) {
        return $app->response->redirect("guess/init");
    }

    $data = [
        "content" => $_SESSION["res"] ?? null,
        "tries" => $_SESSION["tries"]
    ];

    $app->page->add("guess/play", $data);
    // $app->page->add("guess/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
* Play the game.
 */
$app->router->post("guess/post-process", function () use ($app) {

    // Deal with incoming variables
    $guess  = $_POST["guess"] ?? null;
    $make   = $_POST["make"] ?? null;
    $reset  = $_POST["reset"] ?? null;
    $cheat  = $_POST["cheat"] ?? null;

    if(!isset($_SESSION["number"])) {
        return $app->response->redirect("guess/init");
    }
    // Deal with session variables
    $number = $_SESSION["number"];
    $tries = $_SESSION["tries"];

    if ($make) {
        // Make a guess
        $game = New Linder\Guess\Guess($number, $tries);
        try {
            $_SESSION["res"] = $game->makeGuess($guess);
            $tries = $game->tries();
            $_SESSION["tries"] = $tries;
        } catch (Linder\Guess\GuessException $e) {
            $_SESSION["res"] = "Needs to be an integer between 1 and 100.";
        }
    } elseif ($reset) {
        // reset game
        return $app->response->redirect("guess/init");
    } elseif ($cheat) {
        // cheat
        $_SESSION["res"] = "The secret number is " . $number;
    }

    return $app->response->redirect("guess/play");
});
