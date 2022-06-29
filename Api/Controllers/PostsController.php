<?php
namespace Api\Controllers;
require_once(PROJECT_ROOT_PATH."\Api\Models\PostsModel.php");
use Api\Models\PostsModel;
use Exception;

class PostsController {

    private $tipoPeticion;
    public function __construct() {
        $this->tipoPeticion = strtoupper($_SERVER["REQUEST_METHOD"]);

    }

    public function posts($idrecurso = null) {
        try {
            switch ($this->tipoPeticion) {
                case 'GET': 
                    $respuesta = $this->mostrarPost($idrecurso);
                    $textoRespuesta = CODIGOS_ESTADO['200'];
                    break;
                case 'POST':
                    $respuesta = $this->crearPost();
                    $textoRespuesta = CODIGOS_ESTADO['200'];
                    break;
                case 'PUT':
                    $respuesta = $this->actualizarPost($idrecurso);
                    $textoRespuesta = CODIGOS_ESTADO['200'];
                    break;
                case 'DELETE':
                    $respuesta = $this->eliminarPost($idrecurso);
                    $textoRespuesta = CODIGOS_ESTADO['200'];
                    break;
                default:
                throw new Exception('peticion incorrecta', 400);
                
            }

            $header = "HTTP/1.1 200 $textoRespuesta";
            return array('datos' => $respuesta, 'header' => $header);

        } catch (Exception $e) {
            $textoRespuesta = $e->getMessage();
            $codigoError = $e->getCode();
            $textoError = CODIGOS_ESTADO[$codigoError];
            $header = "HTTP/1.1 $codigoError $textoError";
            return array('datos' => $textoRespuesta, 'header' => $header);
        }
    }

    private function mostrarPost($idrecurso){

        //validar id informado
        if($idrecurso) $this->validarID($idrecurso);

        //instanciar modelo
        $postModel = new PostsModel();

        //metodo consulta posts
        $arrayPosts = $postModel->getPosts($idrecurso);

        return json_encode($arrayPosts);
    }

    private function crearPost() {

         //obtener datos
         $inputJSON = file_get_contents('php://input');
         $datos = json_decode($inputJSON, TRUE);
 
         //validar datos
         $this->validarDatos($datos);
 
         //instanciar modelo
         $postModel = new PostsModel();
 
         //metodo de modificacion
         $arrayPosts = $postModel->createPosts($datos);
 
         return json_encode($datos);

    }

    private function actualizarPost($idrecurso) {

        // validar id informado y numerico
        if($idrecurso) $this->validarId($idrecurso);

        //obtener datos
        $inputJSON = file_get_contents('php://input');
        $datos = json_decode($inputJSON, TRUE);

        //validar datos
        $this->validarDatos($datos);

        //instanciar modelo
        $postModel = new PostsModel();

        //metodo de modificacion
        $arrayPosts = $postModel->updatePosts($idrecurso, $datos);

        return json_encode($arrayPosts);
    }

    private function eliminarPost($idrecurso) {

        // validar id informado y numerico
        if($idrecurso) $this->validarId($idrecurso);

        //instanciar modelo
        $postModel = new PostsModel();

        //metodo de modificacion
        $arrayPosts = $postModel->deletePosts($idrecurso);

        return json_encode($arrayPosts);


    }

    private function validarDatos($datos) {
        if (!$datos['title']){
            throw new Exception('Peticion incorrecta o incompleta', 400);
        }
        if (!$datos['status']){
            throw new Exception('Peticion incorrecta o incompleta', 400);
        }
        if (!$datos['content']){
            throw new Exception('Peticion incorrecta o incompleta', 400);
        }
        if (!$datos['user_id']){
            throw new Exception('Peticion incorrecta o incompleta', 400);
        }

    }

    private function validarId($idrecurso){
        if (!$idrecurso){
            throw new Exception('Peticion incorrecta o incompleta', 400);
        } else {
            return true;
        }
    }
}