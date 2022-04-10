<?php

require 'Mensagem.php';

$mensagem = new Mensagem;

$mensagem->__set('email', $_POST['email']);
$mensagem->__set('assunto', $_POST['assunto']);
$mensagem->__set('mensagem', $_POST['mensagem']);

if(!$mensagem->mensagemValida()) {
    echo 'Mensagem não é válida';
    header('Location: index.php');
}

$mensagem->enviaEmail();

require 'Error.php';