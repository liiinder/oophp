<?php
/**
 * Routes to ease testing.
 */
return [
    // Path where to mount the routes, is added to each route path.
    // "mount" => "sample",

    // All routes in order
    "routes" => [
        [
            "info" => "Sample controller app style.",
            "mount" => "hundred2",
            "handler" => "\Linder\Hundred2\HundredController",
        ],
        // [
        //     "info" => "Sample controller di style.",
        //     "mount" => "di",
        //     "handler" => "\Anax\Controller\SampleController",
        // ],
        // [
        //     "info" => "Sample controller di style with json responses.",
        //     "mount" => "json",
        //     "handler" => "\Anax\Controller\SampleJsonController",
        // ],
    ]
];
