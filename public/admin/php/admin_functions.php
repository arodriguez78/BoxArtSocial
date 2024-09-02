<?php
require_once($function_url ?? '../../assets/php/functions.php');

//para comprobar el usuario
function checkAdminUser($login_data)
{
    global $db;
    $email = $login_data['email'];
    $password = md5($login_data['password']);

    $query = "SELECT * FROM admin WHERE email='$email' && password='$password'";
    $run = mysqli_query($db, $query);
    $data['user'] = mysqli_fetch_assoc($run) ?? array();
    if (count($data['user']) > 0) {
        $data['status'] = true;
        $data['user_id'] = $data['user']['id'];
    } else {
        $data['status'] = false;
    }

    return $data;
}

//conseguir admin
function getAdmin($user_id)
{
    global $db;
    $query = "SELECT * FROM admin WHERE id=$user_id";
    $run = mysqli_query($db, $query);
    return mysqli_fetch_assoc($run);
}

//numero total de comentarios
function totalCommentsCount()
{
    global $db;
    $query = "SELECT count(*) as row FROM comments";
    $run = mysqli_query($db, $query);
    return mysqli_fetch_assoc($run)['row'];
}

//numero total de posts
function totalPostsCount()
{
    global $db;
    $query = "SELECT count(*) as row FROM posts";
    $run = mysqli_query($db, $query);
    return mysqli_fetch_assoc($run)['row'];
}

//numero de usuarios
function totalUsersCount()
{
    global $db;
    $query = "SELECT count(*) as row FROM users";
    $run = mysqli_query($db, $query);
    return mysqli_fetch_assoc($run)['row'];
}

//numero total de likes
function totalLikesCount()
{
    global $db;
    $query = "SELECT count(*) as row FROM likes";
    $run = mysqli_query($db, $query);
    return mysqli_fetch_assoc($run)['row'];
}

//conseguir lista de usuarios
function getUsersList()
{
    global $db;
    $query = "SELECT * FROM users ORDER BY id DESC";
    $run = mysqli_query($db, $query);
    return mysqli_fetch_all($run, true);
}

//iniciar sesion en una cuenta como admin
function loginUserByAdmin($email)
{
    global $db;


    $query = "SELECT * FROM users WHERE email='$email'";
    $run = mysqli_query($db, $query);
    $data['user'] = mysqli_fetch_assoc($run) ?? array();
    if (count($data['user']) > 0) {
        $data['status'] = true;
    } else {
        $data['status'] = false;
    }

    return $data;
}

//bloquear cuenta como admin
function blockUserByAdmin($user_id)
{
    global $db;
    $query = "UPDATE users SET ac_status=2 WHERE id=$user_id";
    return mysqli_query($db, $query);
}

//desbloquear una cuenta como admin
function unblockUserByAdmin($user_id)
{
    global $db;
    $query = "UPDATE users SET ac_status=1 WHERE id=$user_id";
    return mysqli_query($db, $query);
}

//actualizar perfil de administrador
function updateAdmin($data)
{
    global $db;
    $password = md5($data['password']);
    $password_text = $data['password'];
    $full_name = $data['full_name'];
    $email = $data['email'];
    $user_id = $data['user_id'];
    $query = "UPDATE admin SET full_name='$full_name',email='$email',password='$password',password_text='$password_text' WHERE id=$user_id";
    return mysqli_query($db, $query);
}

//borrar un usuario como administrador
function deleteUserByAdmin($user_id)
{
    global $db;
    $query = "DELETE FROM users WHERE id=$user_id";
    return mysqli_query($db, $query);
}