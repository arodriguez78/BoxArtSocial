<?php
require_once 'functions.php';
require_once 'send_code.php';


if (isset($_GET['test'])) {
}

if (isset($_GET['block'])) {
    $user_id = $_GET['block'];
    $user = $_GET['username'];
    if (blockUser($user_id)) {
        header("location:../../?u=$user");
    } else {
        echo "Algo salió mal";
    }
}

if (isset($_GET['deletepost'])) {
    $post_id = $_GET['deletepost'];
    if (deletePost($post_id)) {
        header("location:{$_SERVER['HTTP_REFERER']}");
    } else {
        echo "Algo salió mal";
    }
}


//registro
if (isset($_GET['signup'])) {
    $response = validateSignupForm($_POST);
    if ($response['status']) {
        if (createUser($_POST)) {
            header('location:../../?login&newuser');
        } else {
            echo "<script>alert('Algo está mal')</script>";
        }
    } else {
        $_SESSION['error'] = $response;
        $_SESSION['formdata'] = $_POST;
        header("location:../../?signup");
    }
}


//login
if (isset($_GET['login'])) {

    $response = validateLoginForm($_POST);

    if ($response['status']) {
        $_SESSION['Auth'] = true;
        $_SESSION['userdata'] = $response['user'];

        if ($response['user']['ac_status'] == 0) {
            $_SESSION['code'] = $code = rand(111111, 999999);
            sendCode($response['user']['email'], 'Verifica tu email', $code);
        }

        header("location:../../");
    } else {
        $_SESSION['error'] = $response;
        $_SESSION['formdata'] = $_POST;
        header("location:../../?login");
    }
}


if (isset($_GET['resend_code'])) {

    $_SESSION['code'] = $code = rand(111111, 999999);
    sendCode($_SESSION['userdata']['email'], 'Verifica tu email ', $code);
    header('location:../../?resended');
}

if (isset($_GET['verify_email'])) {
    $user_code = $_POST['code'];
    $code = $_SESSION['code'];
    if ($code == $user_code) {
        if (verifyEmail($_SESSION['userdata']['email'])) {
            header('location:../../');
        } else {
            echo "something is wrong";
        }
    } else {
        $response['msg'] = 'Codigo de verificación incorrecto';
        if (!$_POST['code']) {
            $response['msg'] = 'Introduce el código de 6 dígitos';
        }
        $response['field'] = 'email_verify';
        $_SESSION['error'] = $response;
        header('location:../../');
    }
}


if (isset($_GET['forgotpassword'])) {
    if (!$_POST['email']) {
        $response['msg'] = "introduce tu email";
        $response['field'] = 'email';
        $_SESSION['error'] = $response;
        header('location:../../?forgotpassword');
    } elseif (!isEmailRegistered($_POST['email'])) {
        $response['msg'] = "el email no está registrado";
        $response['field'] = 'email';
        $_SESSION['error'] = $response;
        header('location:../../?forgotpassword');
    } else {
        $_SESSION['forgot_email'] = $_POST['email'];
        $_SESSION['forgot_code'] = $code = rand(111111, 999999);
        sendCode($_POST['email'], '¿Olvidaste tu contraseña? ', $code);
        header('location:../../?forgotpassword&resended');
    }
}



//logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('location:../../');
}


//codigo de verificación
if (isset($_GET['verifycode'])) {
    $user_code = $_POST['code'];
    $code = $_SESSION['forgot_code'];
    if ($code == $user_code) {
        $_SESSION['auth_temp'] = true;
        header('location:../../?forgotpassword');
    } else {
        $response['msg'] = 'Codigo de verificación incorrecto';
        if (!$_POST['code']) {
            $response['msg'] = 'Introduce el código de 6 dígitos';
        }
        $response['field'] = 'email_verify';
        $_SESSION['error'] = $response;
        header('location:../../?forgotpassword');
    }
}

if (isset($_GET['changepassword'])) {
    if (!$_POST['password']) {
        $response['msg'] = "Introduce tu nueva contraseña";
        $response['field'] = 'password';
        $_SESSION['error'] = $response;
        header('location:../../?forgotpassword');
    } else {
        resetPassword($_SESSION['forgot_email'], $_POST['password']);
        session_destroy();
        header('location:../../?reseted');
    }
}


if (isset($_GET['updateprofile'])) {

    $response = validateUpdateForm($_POST, $_FILES['profile_pic']);

    if ($response['status']) {

        if (updateProfile($_POST, $_FILES['profile_pic'])) {
            header("location:../../?editprofile&success");
        } else {
            echo "Algo está mal";
        }
    } else {
        $_SESSION['error'] = $response;
        header("location:../../?editprofile");
    }
}

//añadir publicación
if (isset($_GET['addpost'])) {
    $response = validatePostImage($_FILES['post_img']);

    if ($response['status']) {
        if (createPost($_POST, $_FILES['post_img'])) {
            header("location:../../?new_post_added");
        } else {
            echo "Algo esta mal";
        }
    } else {
        $_SESSION['error'] = $response;
        header("location:../../");
    }
}
