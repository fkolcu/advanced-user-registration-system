<?php
declare(strict_types=1);

use Slim\App;
use App\Application\Actions\User\RegisterAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return function (App $app) {
    $app->get("/register", function (Request $request, Response $response) {
        $response->getBody()->write('<form method="post" action="/register/html">' .
            '<input type="email" name="email" placeholder="Email">' .
            '<input type="password" name="password" placeholder="Password">' .
            '<input type="submit" value="Register">' .
            '</form>');
        return $response;
    });

    $app->post("/register[/{requestType}]", RegisterAction::class);
};