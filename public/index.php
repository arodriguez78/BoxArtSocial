<?php

require_once 'assets/php/functions.php';
if(isset($_GET['newfp'])){
    unset($_SESSION['auth_temp']);
    unset($_SESSION['forgot_email']);
    unset($_SESSION['forgot_code']);
}
if(isset($_SESSION['Auth'])){
    $user = getUser($_SESSION['userdata']['id']);
    $posts = filterPosts();
    $follow_suggestions = filterFollowSuggestion();
}

$pagecount = count($_GET);


//manage pages
if(isset($_SESSION['Auth']) && $user['ac_status']==1 && !$pagecount){
    showPage('header',['page_title'=>'Inicio']);
    showPage('navbar');
    showPage('wall');
}elseif(isset($_SESSION['Auth']) && $user['ac_status']==0 && !$pagecount){

    showPage('header',['page_title'=>'Verifica tu email']);
    showPage('verify_email');
}elseif(isset($_SESSION['Auth']) && $user['ac_status']==2 && !$pagecount){
    showPage('header',['page_title'=>'Bloqueado']);
    showPage('blocked');
}elseif(isset($_SESSION['Auth']) && isset($_GET['editprofile']) && $user['ac_status']==1){
    showPage('header',['page_title'=>'Editar Perfil']);
    showPage('navbar');
    showPage('edit_profile');
}elseif(isset($_SESSION['Auth']) && isset($_GET['u']) && $user['ac_status']==1){
    $profile = getUserByUsername($_GET['u']);
    if(!$profile){
        showPage('header',['page_title'=>'Usuario no encontrado']);
        showPage('navbar');
        showPage('user_not_found');

    }else{
     $profile_post = getPostById($profile['id']);  
     $profile['followers']=getFollowers($profile['id']);
     $profile['following']=getFollowing($profile['id']);
        showPage('header',['page_title'=>$profile['first_name'].' '.$profile['last_name']]);
        showPage('navbar');
        showPage('profile');
    }
 
  
}elseif(isset($_GET['signup'])){
    showPage('header',['page_title'=>'Boxart - Registro']);
    showPage('signup');
}elseif(isset($_GET['login'])){
   
    showPage('header',['page_title'=>'Boxart - Inicio de Sesión']);
    showPage('login');
}elseif(isset($_GET['forgotpassword'])){
    
    showPage('header',['page_title'=>'Boxart - Olvidaste tu contraseña']);
    showPage('forgot_password');
}else{
    if(isset($_SESSION['Auth']) && $user['ac_status']==1){
        showPage('header',['page_title'=>'Home']);
        showPage('navbar');
        showPage('wall');
    }elseif(isset($_SESSION['Auth']) && $user['ac_status']==0){

        showPage('header',['page_title'=>'Verifica tu email']);
        showPage('verify_email');
    }elseif(isset($_SESSION['Auth']) && $user['ac_status']==2){
        showPage('header',['page_title'=>'Bloqueado']);
        showPage('blocked');
    }else{
        showPage('header',['page_title'=>'Boxart - Inicio de sesión']);
        showPage('login');
    }
  
}


showPage('footer');
unset($_SESSION['error']);
unset($_SESSION['formdata']);







