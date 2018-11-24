<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->get('/',function (Request $request, Response $response, array $args){
    return $this->renderer->render($response, 'index.phtml', $args);
});

$app->get('/games', function (Request $request, Response $response, array $args) {

    try{
        $data = ['success' => false, 'msg' => 'Could not get data.', 'data' => []];
        $statusCode = 404;
        $query = $this->db->prepare("SELECT `id`, `name` FROM `games`;");
        $result = $query->execute();
        $games = $query->fetchAll();
        if($result && $games !== NULL){
            $data = ['success' => true, 'msg' => 'Have some games!', 'data' => ["games"=>$games]];
            $statusCode = 200;
        }

        // Render index view
        return $response->withJson($data, $statusCode);
    } catch (Exception $e){
        $data = ['success' => false, 'msg' => $e->getMessage(), 'data' => []];
        $statusCode = 404;
        return $response->withJson($data, $statusCode);
    }
});

$app->get('/users', function (Request $request, Response $response, array $args) {

    try{
        $data = ['success' => false, 'msg' => 'Could not get users.', 'data' => []];
        $statusCode = 404;
        $query = $this->db->prepare("SELECT `id`, `name` FROM `users`;");
        $result = $query->execute();
        $users = $query->fetchAll();
        if($result && $users !== NULL){
            $data = ['success' => true, 'msg' => 'Have some users!', 'data' => ["users"=>$users]];
            $statusCode = 200;
        }

        // Render index view
        return $response->withJson($data, $statusCode);
    } catch (Exception $e){
        $data = ['success' => false, 'msg' => $e->getMessage(), 'data' => []];
        $statusCode = 404;
        return $response->withJson($data, $statusCode);
    }
});

$app->get('/games/score/{id}', function (Request $request, Response $response, array $args) {

    try{
        $data = ['success' => false, 'msg' => 'Could not get data.', 'data' => []];
        $statusCode = 404;
        $query = $this->db->prepare("SELECT `users`.`id`, `users`.`name`, `scores`.`score`
FROM `users`
LEFT JOIN `scores` 
ON `users`.`id` = `scores`.`user_id`
LEFT JOIN `games`
ON `scores`.`game_id` = `games`.`id`
WHERE `games`.`id` = :gameId;");
        $query->bindParam(':gameId', $args['id']);
        $result = $query->execute();
        $scores = $query->fetchAll();
        if($result && $scores !== NULL){
            $data = ['success' => true, 'msg' => 'Have some scores!', 'data' => ["scores"=>$scores]];
            $statusCode = 200;
        }

        // Render index view
        return $response->withJson($data, $statusCode);
    } catch (Exception $e){
        $data = ['success' => false, 'msg' => $e->getMessage(), 'data' => []];
        $statusCode = 404;
        return $response->withJson($data, $statusCode);
    }
});

$app->get('/user/score/{userId}/{gameId}', function (Request $request, Response $response, array $args) {

    try{
        $data = ['success' => false, 'msg' => 'Could not get data.', 'data' => []];
        $statusCode = 404;
        $query = $this->db->prepare("SELECT count(`score`) AS `scores`, `score` FROM `scores` WHERE `user_id` = :userId AND `game_id` = :gameId;");
        $query->bindParam(':userId', $args['userId']);
        $query->bindParam(':gameId', $args['gameId']);
        $result = $query->execute();
        $scores = $query->fetchAll();
        if($result && $scores !== NULL){
            $data = ['success' => true, 'msg' => 'Have some scores!', 'data' => ["scores"=>$scores]];
            $statusCode = 200;
        }

        // Render index view
        return $response->withJson($data, $statusCode);
    } catch (Exception $e){
        $data = ['success' => false, 'msg' => $e->getMessage(), 'data' => []];
        $statusCode = 404;
        return $response->withJson($data, $statusCode);
    }
});

$app->get('/addToExistingScore/{userId}/{gameId}/{newScore}', function (Request $request, Response $response, array $args) {

    try{
        $data = ['success' => false, 'msg' => 'Could not add to score.', 'data' => []];
        $statusCode = 404;
        $query = $this->db->prepare("UPDATE `scores`
SET `score` = :newScore
WHERE `user_id` = :userId AND `game_id` = :gameId;");
        $query->bindParam(':userId', $args['userId']);
        $query->bindParam(':gameId', $args['gameId']);
        $query->bindParam(':newScore', $args['newScore']);
        $result = $query->execute();
        $scores = $query->fetchAll();
        if($result && $scores !== NULL){
            $data = ['success' => true, 'msg' => 'Have some scores!', 'data' => ["scores"=>$scores]];
            $statusCode = 200;
        }

        // Render index view
        return $response->withJson($data, $statusCode);
    } catch (Exception $e){
        $data = ['success' => false, 'msg' => $e->getMessage(), 'data' => []];
        $statusCode = 404;
        return $response->withJson($data, $statusCode);
    }
});

$app->get('/addNewScore/{userId}/{gameId}', function (Request $request, Response $response, array $args) {

    try{
        $data = ['success' => false, 'msg' => 'Could not add to score.', 'data' => []];
        $statusCode = 404;
        $query = $this->db->prepare("INSERT INTO `scores` (`game_id`, `user_id`, `score`) VALUES (:gameId,:userId,1);");
        $query->bindParam(':userId', $args['userId']);
        $query->bindParam(':gameId', $args['gameId']);
        $result = $query->execute();
        $scores = $query->fetchAll();
        if($result && $scores !== NULL){
            $data = ['success' => true, 'msg' => 'Have some scores!', 'data' => ["scores"=>$scores]];
            $statusCode = 200;
        }

        // Render index view
        return $response->withJson($data, $statusCode);
    } catch (Exception $e){
        $data = ['success' => false, 'msg' => $e->getMessage(), 'data' => []];
        $statusCode = 404;
        return $response->withJson($data, $statusCode);
    }
});

$app->post('/api/addGame', function(Request $request, Response $response, array $args){
    try{
        $data = ['success' => false, 'msg' => 'New Game not added.', 'data' => []];
        $statusCode = 404;
        $userData = $request->getParsedBody();
        $gameName = $userData['game'];
        $query = $this->db->prepare("INSERT INTO `games` (`name`) VALUES (:game);");
        $query->bindParam(':game', $gameName);
        $results = $query->execute();
        $id = $this->db->lastInsertId();
        if($results && $gameName !== NULL){
            $data = ['success' => true, 'msg' => 'New Game added!', 'data' => ["id"=>$id, "gameName"=>$gameName]];
            $statusCode = 200;
        }


        return $response->withJson($data, $statusCode);
    } catch (Exception $e){
        $data = ['success' => false, 'msg' => $e->getMessage(), 'data' => []];
        $statusCode = 404;
        return $response->withJson($data, $statusCode);
    }
});

$app->post('/api/addUser', function(Request $request, Response $response, array $args){
    try{
        $data = ['success' => false, 'msg' => 'New User not added.', 'data' => []];
        $statusCode = 404;
        $userData = $request->getParsedBody();
        $userName = $userData['user'];
        $query = $this->db->prepare("INSERT INTO `users` (`name`) VALUES (:user);");
        $query->bindParam(':user', $userName);
        $results = $query->execute();
        $id = $this->db->lastInsertId();
        if($results && $userName !== NULL){
            $data = ['success' => true, 'msg' => 'New User added!', 'data' => ["id"=>$id, "userName"=>$userName]];
            $statusCode = 200;
        }


        return $response->withJson($data, $statusCode);
    } catch (Exception $e){
        $data = ['success' => false, 'msg' => $e->getMessage(), 'data' => []];
        $statusCode = 404;
        return $response->withJson($data, $statusCode);
    }
});
