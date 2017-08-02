<?php
require_once("assets/php/class.seg.php");
session_start();
proteger();

$host="10.0.0.2";
$service="//10.0.0.2:1521/orcl";
$conn= new \PDO("oci:host=$host;dbname=$service","PORTAL","aN1G3rp4I#");

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

    <title>Ordens de compra - Portal Aniger</title>

    <link href="assets/css/bootstrap.min.css" rel="stylesheet">    
    <link href="assets/css/theme.css" rel="stylesheet">
    <link href="assets/css/font-awesome.css" rel="stylesheet" type="text/css" />
            
  </head>

  <body>

    <!-- NAV -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"> <img src="assets/img/logo.png" alt="Aniger" height="23" > </a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="">       <a href="index.php"><i class="fa fa-home fa-fw"></i> Home</a></li>
            <li class="">       <a href="cotacoes.php"><i class="fa fa-list-alt fa-fw"></i> Cota&ccedil;&otilde;es</a></li>
            <li class="active"> <a href="ordens.php"><i class="fa fa-file-text fa-fw"></i> Ordens de compra</a></li>            
          </ul>

          <!-- MENU -->
          <span class="navbar-text pull-right"> <?php echo $_SESSION['usuarioNome'].' '.$_SESSION['usuarioSobreNome'] ?> | <a data-toggle="dropdown" class="navbar-link dropdown-toggle" href="#" id="user-options"><i class="fa fa-cogs fa-fw"></i></a>                          
            <ul class="dropdown-menu" role="menu">              
              <li class="">
                <?php echo '<a title="Alterar sua senha"><span style="cursor:pointer;" data-toggle="modal" data-target="#SEModal">&nbsp;<i class="fa fa-unlock-alt"></i>&nbsp;&nbsp; Alterar senha</span></a>';?>
              </li>              
              <li class="divider"></li>
              <li>
                <a href="assets/php/vLogout.php"><i class="fa fa-sign-out fa-fw"></i> Sair</a>
              </li>             
            </ul>
          </span></a>

        </div>

        <div id="navbar" class="navbar-collapse collapse">          
        </div><!--/.nav-collapse -->
      
      </div>
    </nav>

    <!-- CONTAINER -->
    <div class="container" role="main">            

      <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-6" style=""> 
          <h3><i class="fa fa-file-text fa-fw"></i> Ordens de compra <span class="badge"><?php echo $result1['QUANTIDADE']; ?>  </span> </h3>
        </div>          
        <div class="col-md-6 col-sm-6 col-xs-6" style="text-align:right;">
          <h3><i class="fa fa-plus fa-fw"></i>  </h3>
        </div>
        </div>
        <hr>

         <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="grid simple ">
            <div class="grid-title no-border">
              <!--<div class="tools">
                <a href="#"><i class="fa fa-plus fa-lg"></i> </a>
              </div>-->
            </div>
            <div class="grid-body no-border">
              <!--<h3><i class="fa fa-bars fa-1x"></i><span class="semi-bold">&nbsp; Menus</span></h3>-->
              <table class="table table-hover table-responsive">
                <thead>
                  <tr>                                                
                    <th style="width:40%">Ordem de compra</th>                    
                    <th style="width:40%">Fornecedores</th>                    
                    <th style="width:15%">Cria&ccedil;&atilde;o</th>
                    <th style="width:15%">Situa&ccedil;&atilde;o</th>                    
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $rr=1;
                  foreach ($result2 as $key2 => $value) {
                    echo '
                      <tr>                                                        
                        <td class="v-align-middle"><span class="muted">'.$result2[$key2]['CODIGO'].'</span></td>
                        <td class="v-align-middle"><span class="muted"><i class="fa fa-group"></i></span></td>
                        <td class="v-align-middle"><span class="muted">'.$result2[$key2]['DATA_CRIACAO'].'</span></td>
                        <td class="v-align-middle"><span class="muted"><span class="'.$result2[$key2]['LABEL'].'">'.$result2[$key2]['DESC_SIT'].'</span></span></td>                                                                                                                      
                      </tr>
                      ';
                    $rr++;
                  }                        
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

      </div>

      <div class="modal fade" id="SEModal" tabindex="-1" role="dialog" aria-labelledby="SEModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header" style="text-align:center; color:grey;" >
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>                                                
              <br>
              <i class="fa fa-unlock-alt fa-5x"></i>
              <h4 id="SEModalLabel" class="semi-bold">Alterar senha</h4>                  
            </div>
            <div class="modal-body"> 
              <div class="">
                <div class="row" style="line-height:2;">
                  <form method="post" name="ramal" action="assets/php/senha.A.php">                          

                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                      <div class="controls">
                        <input type="password" placeholder="Nova senha" class="form-control input input-lg" title="Digite a nova senha com pelo menos 5 caracteres." style="text-align: center" name="senha" maxlength="20" pattern=".{0}|.{5,20}" required>
                      </div>
                    </div>                                             

                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                      <button type="submit" class="btn btn-primary btn-block btn-large" value="submit"> Alterar</button>                                        
                    </div>

                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>      

    </div> <!-- /CONTAINER -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>    
    <script src="assets/js/bootstrap.min.js"></script>

  </body>
</html>
