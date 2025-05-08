<?php

function basePath($path)
{
    return __DIR__ . '/' . $path;
}

function loadPartial($partialName)
{
    $partialFilePath = basePath("src/views/partials/") . "{$partialName}.partial.php";
    if (file_exists($partialFilePath)) {
        require($partialFilePath);
    } else {
        echo "View doesn't exist";
    }
}

function loadView($viewName)
{
    $viewFilePath = basePath("src/views/") . "{$viewName}.view.php";
    if (file_exists($viewFilePath)) {
        require($viewFilePath);
    } else {
        echo "View doesn't exist";
    }
}
