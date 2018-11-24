<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

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
