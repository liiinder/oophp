<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));


/**
 * Main page of blogg/content page
 */
$app->router->get("blogg/main", function () use ($app) {
    $title = "Min bloggsida";

    $app->page->add("blogg/nav");

    $app->db->connect();
    $sql = "SELECT * FROM content;";
    $res = $app->db->executeFetchAll($sql);

    $data = [
        "res" => $res
    ];

    $app->page->add("blogg/main", $data);

    return $app->page->render([
        "title" => $title
    ]);
});

/**
 * admin page of blogg/content page
 */
$app->router->get("blogg/admin", function () use ($app) {
    $title = "Min bloggsida";

    $app->page->add("blogg/nav");

    $app->db->connect();
    $sql = "SELECT * FROM content;";
    $res = $app->db->executeFetchAll($sql);

    $data = [
        "res" => $res
    ];

    $app->page->add("blogg/admin", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * create page of blogg/content page
 */
$app->router->get("blogg/create", function () use ($app) {
    $title = "Min bloggsida";

    $app->page->add("blogg/nav");

    $data = [
        "nothing" => "at the moment"
    ];

    $app->page->add("blogg/create", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Edit page of blogg/content
 */
$app->router->get("blogg/edit/{id}", function ($id) use ($app) {
    $title = "Edit content id: " . $id;

    $app->page->add("blogg/nav");
    $app->db->connect();
    $sql = "SELECT * FROM content WHERE id = ?;";
    $res = $app->db->executeFetch($sql, [$id]);

    $data = [
        "res" => $res
    ];

    $app->page->add("blogg/edit", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Post route for edit the blogg/content
 */
$app->router->post("blogg/edit/{contentId}", function ($contentId) use ($app) {
    $contentId = $app->request->getPost("contentId") ?: $contentId;
    $params = [];
    if ($app->request->getPost("doDelete")) {
        $app->response->redirect("blogg/delete/" . $contentId);
    } elseif ($app->request->getPost("doSave")) {
        $keys = [
            "contentTitle",
            "contentPath",
            "contentSlug",
            "contentData",
            "contentType",
            "contentFilter",
            "contentPublish",
            "contentId"
        ];
        foreach ($keys as $key) {
            $value = $app->request->getPost($key);
            array_push($params, $value);
        };

        $app->db->connect();

        $slug = $app->request->getPost("contentSlug");
        if ($slug != "") {
            $sql = "SELECT id, count(slug) AS slug FROM content WHERE slug LIKE ?";
            $res = $app->db->executeFetch($sql, [$slug]);
            if ($res->slug == 1 && $res->id != $contentId) {
                $id = 0;
                while (true) {
                    $new = $slug . "-" . $id;
                    $res = $app->db->executeFetch($sql, [$new]);
                    if ($res->slug == 0) {
                        break;
                    }
                    $id++;
                }
                $params[2] = $new;
            }
        }

        $path = $app->request->getPost("contentPath");
        if ($path != "") {
            $sql = "SELECT id, count(path) AS path FROM content WHERE path LIKE ?";
            $res = $app->db->executeFetch($sql, [$path]);
            if ($res->path == 1 && $res->id != $contentId) {
                $id = 0;
                while (true) {
                    $new = $path . $id;
                    $res = $app->db->executeFetch($sql, [$new]);
                    if ($res->path == 0) {
                        break;
                    }
                    $id++;
                }
                $params[1] = $new;
            }
        }
        $sql = "UPDATE content SET title=?, path=?, slug=?, data=?, type=?, filter=?, published=? WHERE id = ?;";
        $app->db->execute($sql, $params);
    }

    $app->response->redirect("blogg/edit/" . $contentId);
});

/**
 * Delete get route
 */
$app->router->get("blogg/delete/{id}", function ($id) use ($app) {
    $sql = "UPDATE content SET deleted=NOW() WHERE id=?;";
    $app->db->connect();
    $app->db->execute($sql, [$id]);
    $app->response->redirect("blogg/admin");
});

/**
 * Create get route
 */
$app->router->get("blogg/create", function () use ($app) {
    $title = "Create content";
    $app->page->add("blogg/nav");

    $data = [
        "res" => $res
    ];

    $app->page->add("blogg/edit", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Create post route
 */
$app->router->post("blogg/create", function () use ($app) {
    $sql = "INSERT INTO `content` (`title`) VALUES (?);";
    $app->db->connect();
    $app->db->execute($sql, [$app->request->getPost("contentTitle")]);
    // $sql = "SELECT MAX(id) as id FROM content;";
    // $res = $app->db->executeFetch($sql);

    // $app->response->redirect("blogg/edit/" . $res->id);
    $app->response->redirect("blogg/edit/" . $app->db->lastInsertId());
});

/**
 * Pages get route
 */
$app->router->get("blogg/pages", function () use ($app) {
    $title = "Mina sidor";

    $app->page->add("blogg/nav");

    $app->db->connect();
    $sql = "SELECT * FROM content WHERE type LIKE 'page';";
    $res = $app->db->executeFetchAll($sql);

    $data = [
        "res" => $res
    ];

    $app->page->add("blogg/pages", $data);

    return $app->page->render([
        "title" => $title
    ]);
});

/**
 * Pages get route
 */
$app->router->get("blogg/page/{path}", function ($path) use ($app) {
    $title = "Mina sidor";

    $app->page->add("blogg/nav");

    $app->db->connect();
    $sql = "SELECT * FROM content WHERE path like ?;";
    $res = $app->db->executeFetch($sql, [$path]);

    $activefilters = [];
    foreach (["bbcode", "link", "markdown", "nl2br"] as $filter) {
        if (strpos($res->filter, $filter) !== false) {
            array_push($activefilters, $filter);
        }
    }
    $textfilter = new Linder\MyTextFilter\MyTextFilter();
    $text = $textfilter->parse($res->data, $activefilters);

    $data = [
        "res" => $res,
        "text" => $text
    ];

    $app->page->add("blogg/page", $data);

    return $app->page->render([
        "title" => $title
    ]);
});

/**
 * Bloggposts get route
 */
$app->router->get("blogg/posts", function () use ($app) {
    $title = "Mina blogginlägg";

    $app->page->add("blogg/nav");

    $app->db->connect();
    $sql = "SELECT * FROM content WHERE type LIKE 'post';";
    $res = $app->db->executeFetchAll($sql);

    $data = [
        "res" => $res
    ];

    $app->page->add("blogg/posts", $data);

    return $app->page->render([
        "title" => $title
    ]);
});

/**
 * Post get route
 */
$app->router->get("blogg/post/{slug}", function ($slug) use ($app) {
    
    $app->page->add("blogg/nav");
    
    $app->db->connect();
    $sql = "SELECT * FROM content WHERE slug like ?;";
    $res = $app->db->executeFetch($sql, [$slug]);
    
    $title = $res->title;

    $activefilters = [];
    foreach (["bbcode", "link", "markdown", "nl2br"] as $filter) {
        if (strpos($res->filter, $filter) !== false) {
            array_push($activefilters, $filter);
        }
    }
    $textfilter = new Linder\MyTextFilter\MyTextFilter();
    $text = $textfilter->parse($res->data, $activefilters);

    $data = [
        "res" => $res,
        "text" => $text
    ];

    $app->page->add("blogg/post", $data);

    return $app->page->render([
        "title" => $title
    ]);
});
