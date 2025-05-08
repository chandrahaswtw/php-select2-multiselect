<?php

switch ($url) {
    case '/':
        loadView("home");
        break;

    case '/api/features':
        require(basePath("src/api/features.php"));
        break;

    case '/api/projects':
        require(basePath("src/api/projects.php"));
        break;

    default:
        http_response_code(400);
        echo "Route not found";
        break;
}
