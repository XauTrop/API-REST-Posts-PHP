<?php

namespace Api\Models;

require_once(PROJECT_ROOT_PATH."\Api\Models\Database.php");
use Api\Models\Database;
use Exception;

class PostsModel extends Database {
    
    public function getPosts($idrecurso) {

        // consultar os post con o sin idrecurso
        if($idrecurso) {
            $sql = "SELECT * FROM posts WHERE id = :id";
            $params = ["id" => $idrecurso];
            return $this->select($sql, $params);
        } else {
            $sql = "SELECT * FROM posts ORDER by user_id ASC";
            return $this->select($sql);
        }

    }

    public function createPosts($datos) {
        extract($datos);
        $sql = "INSERT INTO posts VALUES(NULL, :title, :status, :content, :user_id)";
        $params = [
            "title" => $title,
            "status" => $status,
            "content" => $content,
            "user_id" => $user_id
        ];

        $this->create($sql, $params);
        return $datos;
        
    }

    public function updatePosts($idrecurso, $datos) {

        extract($datos);
        $sql = "UPDATE posts SET title= :title, status= :status, content = :content, user_id = :user_id WHERE id = :id";
        $params = [
            "title" => $title,
            "status" => $status,
            "content" => $content,
            "user_id" => $user_id,
            "id" => $idrecurso
        ];
        $this->update($sql, $params);
        return $datos;
        
    }

    public function deletePosts($idrecurso) {

        // consultar os post con o sin idrecurso
        if($idrecurso) {
            $sql = "DELETE FROM posts WHERE id = :id";
            $params = ["id" => $idrecurso];
            return $this->delete($sql, $params);
        } else {
            throw new Exception(CODIGOS_ESTADO['410'], 410);
            
        }
        
    }
}