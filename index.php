<?php

require_once("Thunder/autoload.php");
DB::init();

$sql = new SqlSelect();
$sql->fromModel("Usuario")
    ->columns('usuario.nome AS usu_nome, usuario.nickname, grupo.nome AS gru_nome')
    ->joinManyToMany('Grupo')
    ->where("usuario.nome like ", "%ren%");
var_dump($sql->query());
?>
