<?
if($_SERVER["HTTPS"] != "on")
{
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}
header("Strict-Transport-Security: max-age=180; includeSubdomains");
?>



<div class="login">
    <div class="col-sm-12 col-md-4 bg-gradient-lightblue border rounded p-4 shadow-sm">
        <form method="post" action="assets/php/actions.php?login">
            <div class="d-flex justify-content-center">

                <img class="mb-4" src="assets/images/BOXART.png" alt="" height="45">
            </div>
            <h1 class="h5 mb-3 fw-normal">Inicia Sesión</h1>

            <div class="form-floating">
                <input type="text" name="username_email" value="<?= showFormData('username_email') ?>" class="form-control rounded-0" placeholder="Nombre de usuario/correo">
                <label for="floatingInput">Nombre de usuario/correo</label>
            </div>
            <?= showError('username_email') ?>
            <div class="form-floating mt-1">
                <input type="password" name="password" class="form-control rounded-0" id="floatingPassword" placeholder="Contraseña">
                <label for="floatingPassword">contraseña</label>
            </div>
            <?= showError('password') ?>
            <?= showError('checkuser') ?>


            <div class="mt-3 d-flex justify-content-between align-items-center">
                <button class="btn btn-primary" type="submit">Inicio de sesión</button>
                <a href="?signup" class="text-decoration-none">Crear una cuenta nueva</a>
            </div>
            <a href="?forgotpassword&newfp" class="text-decoration-none">¿Olvidaste tu contraseña?</a>
        </form>
    </div>
</div>