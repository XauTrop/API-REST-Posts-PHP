<?php

CONST DB_HOST = 'localhost';
CONST DB_USER = 'root';
CONST DB_PWD = '';
CONST DB_NAME = 'rest_posts';

CONST RECURSOS_VALIDOS = array('posts');

CONST CODIGOS_ESTADO = array(
    '200' => 'OK',
    '201' => 'Recurso creado',
    '204' => 'Peticion OK sin respuesta',
    '400' => 'Peticion incorrecta o incompleta',
    '401' => 'Sin autorizacion',
    '403' => 'Acceso prohibido',
    '404' => 'Recurso no encontrado',
    '410' => 'Recurso ya eliminado o no disponible',
    '500' => 'Error interno del servidor'
);