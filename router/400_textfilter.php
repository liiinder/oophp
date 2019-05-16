<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));


/**
 * Init the game and redirect to play the game.
 */
$app->router->get("mytextfilter", function () use ($app) {
    $title = "Filtrera texten";

    // If we refresh the guess/play and dont have a SESSION, restart game.
    if ($app->session->get("myfilter") === null) {
        $app->session->set("myfilter", [
            "bbcode" => null,
            "link" => null,
            "markdown" => null,
            "nl2br" => null,
            "text" => "",
            "filtered" => ""
        ]);
    }

    $data = [
        "myfilter" => $app->session->get("myfilter")
    ];

    $app->page->add("mytextfilter/view", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
* Play the game.
 */
$app->router->post("mytextfilter/post-process", function () use ($app) {

    // Deal with incoming variables
    $myfilter = $app->session->get("myfilter");
    $myfilter["bbcode"]   = $app->request->getPost("bbcode") ? "checked" : null;
    $myfilter["link"]   = $app->request->getPost("link") ? "checked" : null;
    $myfilter["markdown"]   = $app->request->getPost("markdown") ? "checked" : null;
    $myfilter["nl2br"]   = $app->request->getPost("nl2br") ? "checked" : null;
    $myfilter["text"]   = $app->request->getPost("text") ?? null;
    $activefilters = [];
    foreach (["bbcode", "link", "markdown", "nl2br"] as $filter) {
        if ($myfilter[$filter] === "checked") {
            array_push($activefilters, $filter);
        }
    }
    $textfilter = new Linder\MyTextFilter\MyTextFilter();
    $myfilter["filtered"] = $textfilter->parse($myfilter["text"], $activefilters);
    $app->session->set("myfilter", $myfilter);

    return $app->response->redirect("mytextfilter/index");
});
