<?php
declare(strict_types=1);

use Slim\App;
use App\Application\Actions\User\RegisterAction;

return function (App $app) {
    $app->post("/register", RegisterAction::class);
};