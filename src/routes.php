<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->get('/games', function (Request $request, Response $response, array $args) {

    try{
        $query = $this->db->prepare("SELECT `id`, `name` FROM `games`;");
        $query->execute();
        $results = $query->fetchAll();
        $args['data'] = $results;

        // Render index view
        return $this->renderer->render($response, 'index.phtml', $args);
    } catch (e){
        $args['error'] = e->getMessage();
        return $this->renderer->render($response, 'error.phtml', $args);
    }
});
