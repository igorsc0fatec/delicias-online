<?php
include_once '../model/dao.php';
include_once '../controller/controller-usuario.php';
$dao = new DAO();
$usuario = new Usuario();

session_start();
if (isset($_POST['id'])) {
    $usuario->setOnline(date('Y-m-d H:i:s'));
    $dao->execute("UPDATE tbusuario SET online = '{$usuario->getOnline()}' WHERE idUsuario = {$_POST['id']}");
    session_destroy();
}
echo "<script language='javascript' type='text/javascript'> window.location.href='index.php'</script>";
?>