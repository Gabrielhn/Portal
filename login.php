<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="assets/img/favicon.ico">

    <title>Login - Portal Aniger</title>
 
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">    
    <link href="assets/css/signin.css" rel="stylesheet">
    <link href="assets/css/portal.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/animate.min.css" rel="stylesheet" type="text/css" /> 

  </head>

  <body>

    <div class="container">

      <div class="row login-container animated fadeIn" style="margin-top:5%;">
        <div class="col-md-6 col-md-offset-3 tiles white no-padding">
          <div class="p-t-30 p-l-40 p-b-20 xs-p-t-10 xs-p-l-10 xs-p-b-10">
            <h2 class="normal">
              <img src="assets\img\logo3.png" alt="Aniger">
            </h2>
            <p class="p-b-20">
              "Quanto mais trabalhamos, mais sorte temos!"
            </p>
            <?php
            if (isset($_SESSION['erro'])) {
              echo
                '<div class="alert alert-error" style=" margin-right: 30px;">
                    <i class="pull-left fa fa-asterisk"></i>
                      <h6 style="padding-left: 30px;">'                                  
                          .$_SESSION['erro'].                                          
                      '</h6>                      
                  </div>';
            }              
            ?> 
            <div class="tiles white no-margin text-black tab-content">
            <div role="tabpanel" class="tab-pane active" id="tab_login" style="padding-left:0px; padding-bottom:0px;" >
              <form class="animated fadeIn" method="post" action="assets\php\vLogin.php">
                <div class="row form-row">
                  <div class="col-md-12 col-sm-12" style="padding-right:25px;">
                    <input class="form-control input-lg" id="login_email" name="login_username" placeholder="E-mail" type="email" style="text-align: center" autofocus>
                  </div>
                  <div class="col-md-12 col-sm-12" style="padding-right:25px;">
                    <input class="form-control input-lg" id="login_senha" name="login_pass" placeholder="Senha" type="password" style="text-align: center">
                  </div>
                </div>
                <div class="row p-t-10 m-l-20 m-r-20 xs-m-l-10 xs-m-r-10">
                  <div class="control-group col-md-10">                  
                  </div>
                </div>
                <div style=" margin-right: 10px;">
                  <button type="submit" class="btn btn-info btn-block btn-large" value="submit"><i class="fa fa-check"></i> Entrar</button>
                </div>
              </form>
            </div>
            </div>
            <div role="tablist" align="center" style=" margin-right: 30px;">              
              <hr>
              </div>
              <div>
              <div class="alert alert-info" style=" margin-right: 30px;">
                <i class="pull-left fa fa-asterisk"></i>
                  <h6 style="padding-left: 30px; line-height:150%;">
                    Utilize este portal para troca de informa&ccedil;&otilde;es e visualiza&ccedil;&atilde;o de suas cota&ccedil;&otilde;es e ordens de compra em negocia&ccedil;&atilde;o com a equipe de compras da Aniger.
                    <br>&nbsp;  
                    <p>Bons neg&oacute;cios!</p>
                  </h6>                      
              </div>              
            </div>
          </div>
          </div>
        </div>
      </div>      

    </div> <!-- /container -->

  </body>
</html>
