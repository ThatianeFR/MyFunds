<?php

    session_start();

        unset($_SESSION['autenticado']);
        unset($_SESSION['usuario']);
        unset($_SESSION['nomeUsuario']); 

    session_destroy();

    header("Location: login.php");

    exit();
