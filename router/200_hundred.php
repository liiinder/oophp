<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));


/**
 * Init the game and redirect to play the game.
 */
$app->router->get("hundred/init", function () use ($app) {
    // Init the game
    $game = new Linder\Hundred\Hundred();

    $_SESSION["hundred"] = $game;

    return $app->response->redirect("hundred/play");
});

/**
* Play the game.
 */
$app->router->get("hundred/play", function () use ($app) {
    $title = "Tärningsspel 100";

    // If we refresh the hundred/play and dont have a SESSION, restart game.
    if (!isset($_SESSION["hundred"])) {
        return $app->response->redirect("hundred/init");
    }
    
    // Get variables from session and save to data object
    $game = $_SESSION['hundred'];
    $data = [
        "content" => $_SESSION["res"] ?? null,
        "game" => $game
    ];

    $app->page->add("hundred/play", $data);
    // $app->page->add("hundred/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
* Play the game.
 */
$app->router->post("hundred/post-process", function () use ($app) {

    // Deal with incoming variables
    $roll  = $_POST["roll"] ?? null;
    $save  = $_POST["save"] ?? null;
    $pass  = $_POST["pass"] ?? null;
    $init  = $_POST["init"] ?? null;

    // If we post the guess/play after the session timed out, restart game.
    if (!isset($_SESSION["hundred"]) || $init) {
        return $app->response->redirect("hundred/init");
    }

    // Get variables from session
    $game = $_SESSION['hundred'];

    if ($roll) {
        $game->play("roll");
    } elseif ($save) {
        $game->play("save");
    }

    return $app->response->redirect("hundred/play");
});
