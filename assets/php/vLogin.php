<?php
session_start();
// GET e SET
$host="10.0.0.2";
$service="//10.0.0.2:1521/orcl";
$login_username=$_POST['login_username'];
$login_pass=$_POST['login_pass'];
$conn= new \PDO("oci:host=$host;dbname=$service","PORTAL","aN1G3rp4I#");



    // Valida
    $query = "SELECT ID, EMAIL, NOME, SOBRENOME, SENHA, TIPO, PERFIL FROM PO_USUARIOS WHERE ATIVO='S' AND EMAIL=:email AND SENHA=:senha";

    $stmt = $conn->prepare($query);
    $stmt->bindValue(':email',$login_username);
    $stmt->bindValue(':senha',$login_pass);
    $stmt->execute();

    $result=$stmt->fetch(PDO::FETCH_ASSOC);

    if ( ! $result) { // Nenhum registro                
        $erro = "Usu&aacute;rio ou senha incorretos. Verifique os dados digitados e tente novamente.";
        $_SESSION['erro'] = $erro;    
        header("Location: ../../login.php"); 
    } else {
        unset($_SESSION['erro']);
        $_SESSION['usuarioId'] = $result['ID']; // Valor da coluna EMAIL -> SESSION_usuarioId
        $_SESSION['usuarioEmail'] = $result['EMAIL']; // Valor da coluna EMAIL -> SESSION_usuarioEmail
        $_SESSION['usuarioNome'] = $result['NOME']; //Valor da coluna NOME -> SESSION_usuarioNome
        $_SESSION['usuarioSobreNome'] = $result['SOBRENOME']; //Valor da coluna SOBRENOME -> SESSION_usuarioSobreNome
        $_SESSION['usuarioTipo'] = $result['TIPO']; //Valor da coluna TIPO_USUARIO -> SESSION_usuarioTipo
        $_SESSION['usuarioPerfil'] = $result['PERFIL']; //Valor da coluna PERFIL -> SESSION_usuarioPerfil
        sleep(1);
        header("Location: ../../index.php"); //Abre index

    }

?>