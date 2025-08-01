<?php

return new Service\TweetsService(
    require __DIR__ . '/../config-dev/db-connection.php'
);
