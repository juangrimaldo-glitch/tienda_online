<?php
require_once __DIR__ . '/../models/Usuario.php';

class UsuarioController
{
    public function login()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $pass = isset($_POST['password']) ? $_POST['password'] : '';

        // VERIFICAR CREDENCIALES CORRECTAMENTE
        $user = Usuario::verifyCredentials($email, $pass);

        if ($user) {
            if (session_status() === PHP_SESSION_NONE) session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user'] = $user;

            if ($user['rol_nombre'] === 'admin') {
                header('Location: index.php?url=admin/productos');
                exit;
            } else {
                $keep = isset($_REQUEST['keepnav']) && $_REQUEST['keepnav'] == '1' ? '&keepnav=1' : '';
                header('Location: index.php?url=usuarios/perfil' . $keep);
                exit;
            }
        } else {
            $error = "Credenciales inválidas";
        }
    }

    require_once __DIR__ . '/../views/usuarios/login.php';
}

    public function registro()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = isset($_POST['username']) ? trim($_POST['username']) : '';
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';
            $pass = isset($_POST['password']) ? $_POST['password'] : '';
            $exists = Usuario::findByEmail($email);

            if ($exists) {
                $error = 'Ya existe un usuario con ese email';
            } else {
                $user = Usuario::create($username, $email, $pass);

                if (session_status() === PHP_SESSION_NONE) session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user'] = $user;

                $keep = isset($_REQUEST['keepnav']) && $_REQUEST['keepnav'] == '1' ? '&keepnav=1' : '';
                header('Location: index.php?url=usuarios/perfil' . $keep);
                exit;
            }
        }
        require_once __DIR__ . '/../views/usuarios/registro.php';
    }

    public function perfil()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) {
            $keep = isset($_REQUEST['keepnav']) && $_REQUEST['keepnav'] == '1' ? '&keepnav=1' : '';
            header('Location: index.php?url=usuarios/login' . $keep);
            exit;
        }
        $user = $_SESSION['user'];
        require_once __DIR__ . '/../views/usuarios/perfil.php';
    }

    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        session_unset();
        session_destroy();
        header('Location: index.php');
        exit;
    }
}
