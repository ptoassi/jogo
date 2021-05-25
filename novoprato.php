<?php
session_start();
include "pratos.php";

$pratos = new pratos();
$pratos->loopJogo();
$prato = $pratos->getPrato();
$categoria = $pratos->getCategoria();

if(!empty($prato)) {
    echo json_encode(array('categoria'=>$categoria,'prato'=>$prato));
}else {
    http_response_code(204);
}
?>