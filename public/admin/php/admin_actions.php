<?php
require_once('admin_functions.php');
require_once '../../assets/php/send_code.php';

if (isset($_GET['login'])) {
    if (checkAdminUser($_POST)['status']) {
        $_SESSION['admin_auth'] = checkAdminUser($_POST)['user_id'];
        header('Location:../');
    } else {
        $_SESSION['error'] = [
            "field" => "useraccess",
            "msg" => "Email o contraseña incorrectos",
        ];
        header('Location:../');
    }
}
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location:../');
}
if (isset($_GET['updateprofile'])) {
    if (updateAdmin($_POST)) {
        $_SESSION['error'] = [
            "field" => "adminprofile",
            "msg" => "¡Perfil actualizado con exito!",
        ];
        header('Location:../?edit_profile');
    } else {
        $_SESSION['error'] = [
            "field" => "adminprofile",
            "msg" => "Algo salio mal, intenta de nuevo",
        ];
        header('Location:../?edit_profile');
    }
}

if (isset($_GET['userlogin']) && isset($_SESSION['admin_auth'])) {


    $response = loginUserByAdmin($_GET['userlogin']);


    if ($response['status']) {
        $_SESSION['Auth'] = true;
        $_SESSION['userdata'] = $response['user'];

        if ($response['user']['ac_status'] == 0) {
            $_SESSION['code'] = $code = rand(111111, 999999);
            sendCode($response['user']['email'], 'Verifica tu correo electrónico', $code);
        }

        header("location:../../");
    }
}



if (isset($_GET['deleteuser']) && isset($_SESSION['admin_auth'])) {
    $userId = $_GET['deleteuser'];
    if (deleteUserByAdmin($userId)) {
        $_SESSION['error'] = [
            "field" => "deleteuser",
            "msg" => "Usuario borrado",
        ];
    } else {
        $_SESSION['error'] = [
            "field" => "deleteuser",
            "msg" => "Error al borrar el usuario",
        ];
    }
    header('Location:../');
}