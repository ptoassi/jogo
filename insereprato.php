<?php
session_start();
include "pratos.php";
$pratos = new pratos();
$pratos->setPrato($_POST['prato']);
$pratos->setCategoria($_POST['categoria']);
$pratos->inserePrato();
?>