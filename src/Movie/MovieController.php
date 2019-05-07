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
     * This is the index method action
     *
     * @return object
     */
    public function showAction() : object
    {
        $title = "Movie database";

        $this->app->page->add("movie/header");
        $this->app->db->connect();
        $sql = "SELECT * FROM movie;";
        $res = $this->app->db->executeFetchAll($sql);

        $this->app->page->add("movie/show-movies", [
            "res" => $res,
        ]);
        
        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function titleAction() : object
    {
        $title = "Movie database";
        $res = [];
        $this->app->page->add("movie/header");

        $this->app->page->add("movie/search-title", [
            "res" => $res,
            "search" => ""
        ]);
        
        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function yearAction() : object
    {
        $title = "Movie database";
        $res = [];
        $this->app->page->add("movie/header");

        $this->app->page->add("movie/search-year", [
            "res" => $res,
            "year1" => 1950,
            "year2" => 2050
        ]);
        
        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function searchActionPost() : object
    {
        $res = [];
        $this->app->page->add("movie/header");

        $searchpage = $this->app->request->getPost("route");
        if ($searchpage == "searchtitle") {
            $title = "Search movie by title";
            $search = $this->app->request->getPost("search");
            $sql = "SELECT * FROM movie WHERE title LIKE ?;";
            $params = [$search];
            $this->app->page->add("movie/search-title", [
                "res" => $res,
                "search" => $search
            ]);
        } elseif ($searchpage == "searchyear") {
            $title = "Search movie by year";
            $year1 = $this->app->request->getPost("year1");
            $year2 = $this->app->request->getPost("year2");
            $sql = "SELECT * FROM movie WHERE year >= ? AND year <= ?;";
            $params = [$year1, $year2];
            $this->app->page->add("movie/search-year", [
                "res" => $res,
                "year1" => $year1,
                "year2" => $year2,
            ]);
        }

        $this->app->db->connect();
        $res = $this->app->db->executeFetchAll($sql, $params);

        $this->app->page->add("movie/show-movies", [
            "res" => $res,
        ]);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function selectAction() : object
    {
        $title = "Movie database";

        $this->app->page->add("movie/header");
        $this->app->db->connect();
        $sql = "SELECT * FROM movie;";
        $res = $this->app->db->executeFetchAll($sql);

        $this->app->page->add("movie/movie-select", [
            "res" => $res,
        ]);
        
        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function selectActionPost() : object
    {
        $title = "Movie database";

        $add = $this->app->request->getPost("doAdd");
        $edit = $this->app->request->getPost("doEdit");
        $del = $this->app->request->getPost("doDelete");
        $movie = $this->app->request->getPost("movieId");
        
        $this->app->page->add("movie/header");
        $this->app->db->connect();

        if ($add) {
            $sql = "INSERT INTO movie (title, year, image) VALUES (?, ?, ?);";
            $this->app->db->execute($sql, ["A title", 2017, "img/noimage.png"]);
            $movie = $this->app->db->lastInsertId();
            $edit = true;
        }
        if ($movie && $edit) {
            $sql = "SELECT * FROM movie WHERE id = ?;";
            $param = [$movie];
            $res = $this->app->db->executeFetch($sql, $param);
            $this->app->page->add("movie/movie-edit", [
                "movie" => $res,
            ]);
        } elseif ($movie && $del) {
            $sql = "DELETE FROM movie WHERE id = ?";
            $params = [$movie];
            $this->app->db->execute($sql, $params);
            return $this->app->response->redirect("movie/select");
        } else {
            $this->app->page->add("movie/movie-select", [
                "res" => $res,
            ]);
        }

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function editActionPost() : object
    {
        $title = "Edit database";

        $this->app->page->add("movie/header");

        $save = $this->app->request->getPost("doSave");
        $reset = $this->app->request->getPost("doReset");
        $movie = $this->app->request->getPost("movieId");

        $this->app->db->connect();

        if ($reset) {
            $sql = "SELECT * FROM movie WHERE id = ?;";
            $param = [$movie];
            $res = $this->app->db->executeFetch($sql, $param);
            $this->app->page->add("movie/movie-edit", [
                "movie" => $res,
            ]);
        } elseif ($save) {
            $sql = "UPDATE movie SET title = ?, year = ?, image = ? WHERE id = ?";
            $year = $this->app->request->getPost("movieYear");
            $title = $this->app->request->getPost("movieTitle");
            $img = $this->app->request->getPost("movieImage");
            $params = [$title, $year, $img, $movie];
            $this->app->db->execute($sql, $params);
            return $this->app->response->redirect("movie/show");
        }

        return $this->app->page->render([
            "title" => $title,
        ]);
    }
}
