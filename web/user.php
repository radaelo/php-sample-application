<?php

require __DIR__ . '/../bootstrap.php';

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);

$user = (require __DIR__ . '/../dic/users.php')->getById($id);

if ($user === null) {
    http_response_code(404);
    return;
}

$tweetsService = (require __DIR__ . '/../dic/tweets.php');

$tweets = $tweetsService->getLastByUser($id);
$tweetsCount = $tweetsService->getTweetsCount($id);

switch (require __DIR__ . '/../dic/negotiated_format.php') {
    case "text/html":
        (new Views\Layout(
            "Tweets from @$id",
            new Views\Tweets\Listing($user, $tweets, $tweetsCount)
        ))();
        exit;

    case "application/json":
        header("Content-Type: application/json");
        echo json_encode(["count" => $tweetsCount, "last20" => $tweets]);
        exit;
}

http_response_code(406);
