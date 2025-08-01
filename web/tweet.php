<?php

require __DIR__ . '/../bootstrap.php';

function base_url($path = '') {
    $scheme = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    return $scheme . '://' . $_SERVER['HTTP_HOST'] . '/' . ltrim($path, '/');
}

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
$user_param = filter_input(INPUT_GET, 'user', FILTER_SANITIZE_STRING);

$tweet = (require __DIR__ . '/../dic/tweets.php')->getById($id);

if ($tweet === null) {
    http_response_code(404);
    return;
}

if ($tweet->userId !== $user_param) {
    http_response_code(301);
    header("Location: " . base_url("$tweet->userId/status/$id"));
    exit;
}

switch (require __DIR__ . '/../dic/negotiated_format.php') {
    case "text/html":
        (new Views\Layout(
            "@$user_param - \"$tweet->message\"",
            new Views\Tweets\Page(
                (require __DIR__ . '/../dic/users.php')->getById($user_param),
                $tweet
            )
        ))();
        exit;

    case "application/json":
        header("Content-Type: application/json");
        echo json_encode($tweet);
        exit;
}

http_response_code(406);
