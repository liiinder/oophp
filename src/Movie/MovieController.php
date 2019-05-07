<?php

namespace Linder\Movie;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class MovieController implements AppInjectableInterface
{
    use AppInjectableTrait;



    /**
     * @var string $db a sample member variable that gets initialised
     */
    // private $db = "not active";



    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
    // public function initialize() : void
    // {
    //     // Use to initialise member variables.
    //     $this->db = "active";

    //     // Use $this->app to access the framework services.
    // }




    /**
     * This sample method dumps the content of $app.
     * GET mountpoint/dump-app
     *
     * @return string
     */
    public function dumpAppActionGet() : string
    {
        // Deal with the action and return a response.
        $services = implode(", ", $this->app->getServices());
        return __METHOD__ . "<p>\$app contains: $services";
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function indexAction() : object
    {
        // Deal with the action and return a response.
        $title = "MovieDatabase";

        $data = [
            "content" => "test",
            "game" => "over"
        ];

        $this->app->page->add("movie/index", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }



    // /**
    //  * Init the game
    //  */
    // public function initAction() : object
    // {
    //     $game = new Hundred();

    //     $this->app->session->set('hundred', $game);

    //     return $this->app->response->redirect("hundred2/play");
    // }

    // /**
    //  * Play the game
    //  */
    // public function playAction() : object
    // {
    //     $title = "Tärningsspel 100";

    //     // If we refresh the hundred/play and dont have a SESSION, restart game.
    //     if ($this->app->session->get("hundred") == null) {
    //         return $this->app->response->redirect("hundred2/init");
    //     }
        
    //     // Get variables from session and save to data object
    //     $game = $this->app->session->get('hundred');

    //     $data = [
    //         "content" => $this->app->session->get('res'),
    //         "game" => $game
    //     ];

    //     $this->app->page->add("hundred2/play", $data);
    //     // $app->page->add("hundred/debug");

    //     return $this->app->page->render([
    //         "title" => $title,
    //     ]);
    // }

    // /**
    //  * Post roll
    //  */
    // public function postProcessAction() : object
    // {
    //     // Deal with incoming variables
    //     $roll = $this->app->request->getPost('roll');
    //     $save = $this->app->request->getPost('save');
    //     $init = $this->app->request->getPost('init');

    //     // If we post the guess/play after the session timed out, restart game.
    //     if ($this->app->session->get("hundred") == null || $init) {
    //         return $this->app->response->redirect("hundred2/init");
    //     }

    //     // Get variables from session
    //     $game = $this->app->session->get('hundred');

    //     if ($roll) {
    //         $game->roll();
    //     } elseif ($save) {
    //         $game->save();
    //     }

    //     $this->app->session->set('hundred', $game);

    //     return $this->app->response->redirect("hundred2/play");
    // }
}
