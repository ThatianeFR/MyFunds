<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - MyFunds</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body class="tela-login">

    <div class="login-box">
        <img src="logo.png" alt="MyFunds" class="logo-login">
        <h2>Bem-vindo(a)</h2>
        <p>Faça seu login para acessar o MyFunds.</p>
<form action="" method="post">
    Usuário: <input type="text" name="usuario">
    Senha: <input type="text" name="senha">
    <input type="submit" value="Fazer Login">
</form>

<?php

    session_start();
    
        $acessoPermitido = $_SESSION['autenticado'] ?? null;

        if($acessoPermitido != null){
            header("Location: index.php");
            exit();
        }

            if($_SERVER['REQUEST_METHOD'] === 'POST'){

             $usuario = $_POST['usuario'] ?? null;
             $senha = $_POST['senha'] ?? null;

             $hashArmazenado = password_hash("Adm1234", PASSWORD_DEFAULT);

                if(!is_null($usuario) && !is_null($senha)){

                if($usuario === "admin" && password_verify($senha, $hashArmazenado)){

                       $_SESSION['autenticado'] = true;

                       $_SESSION['usuario'] = $usuario;

                       $_SESSION['nomeUsuario'] = "Administrador";

                       header("Location: index.php"); 
                       exit();

                    }else{
                        echo "<h4>Usuário ou senha inválidos</h4>";
                    }
                }else{
                    echo "<h4>Preencha os campos de usuário e senha</h4>";
                }
            }
?>
    </div> </body>
</html>
