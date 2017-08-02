<?php
require_once("assets/php/class.seg.php");
session_start();
proteger();

$host="10.0.0.2";
$service="//10.0.0.2:1521/orcl";
$conn= new \PDO("oci:host=$host;dbname=$service","PORTAL","aN1G3rp4I#");

$usuario=$_SESSION['usuarioEmail'];

$queryCOT="SELECT COUNT (SITUACAO) AS QUANTIDADE  FROM PO_COTACOES WHERE USUARIO = :usuario AND SITUACAO = :situacao";

#1
$stmtCOT1=$conn->prepare($queryCOT);
$stmtCOT1->bindValue(':usuario',$usuario);
$stmtCOT1->bindValue(':situacao','1');
$stmtCOT1->execute();
$resultSIT1=$stmtCOT1->fetchAll(PDO::FETCH_ASSOC);
$sit1=$resultSIT1[0]['QUANTIDADE'];

#2
$stmtCOT2=$conn->prepare($queryCOT);
$stmtCOT2->bindValue(':usuario',$usuario);
$stmtCOT2->bindValue(':situacao','2');
$stmtCOT2->execute();
$resultSIT2=$stmtCOT2->fetchAll(PDO::FETCH_ASSOC);
$sit2=$resultSIT2[0]['QUANTIDADE'];

#3
$stmtCOT3=$conn->prepare($queryCOT);
$stmtCOT3->bindValue(':usuario',$usuario);
$stmtCOT3->bindValue(':situacao','3');
$stmtCOT3->execute();
$resultSIT3=$stmtCOT3->fetchAll(PDO::FETCH_ASSOC);
$sit3=$resultSIT3[0]['QUANTIDADE'];

#5
$stmtCOT5=$conn->prepare($queryCOT);
$stmtCOT5->bindValue(':usuario',$usuario);
$stmtCOT5->bindValue(':situacao','5');
$stmtCOT5->execute();
$resultSIT5=$stmtCOT5->fetchAll(PDO::FETCH_ASSOC);
$sit5=$resultSIT5[0]['QUANTIDADE'];

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

    <title>Home -   Portal Aniger</title>

    <link href="assets/css/bootstrap.min.css" rel="stylesheet">    
    <link href="assets/css/theme.css" rel="stylesheet">
    <link href="assets/css/font-awesome.css" rel="stylesheet" type="text/css"/>        
    <link href="http://cdnjs.cloudflare.com/ajax/libs/prettify/r224/prettify.min.css" rel="stylesheet" >
    <link href="assets/css/morris.css" rel="stylesheet">
    <!--<link rel="stylesheet" href="lib/example.css">-->

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
            <li class="active"> <a href="index.php"><i class="fa fa-home fa-fw"></i> Home</a></li>
            <li class="">       <a href="cotacoes.php"><i class="fa fa-list-alt fa-fw"></i> Cota&ccedil;&otilde;es</a></li>
            <li class="">       <a href="ordens.php"><i class="fa fa-file-text fa-fw"></i> Ordens de compra</a></li>                                   
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
          <h3><i class="fa fa-line-chart fa-fw"></i> Performance </h3>
        </div>          
        <div class="col-md-6 col-sm-6 col-xs-6" style="text-align:right;">
          <!--<h3><i class="fa fa-plus fa-fw"></i>  </h3>-->
        </div>
        </div>
        <hr>        
        
        <div class="col-md-6 col-sm-6 col-xs-6" style="text-align:center;"> 
          <h3><i class="fa fa-list-alt fa-fw"></i> Cota&ccedil;&otilde;es </h3>
          <div id="graphCOT" style="height: 250px;"></div>                    
        </div>          
        <div class="col-md-6 col-sm-6 col-xs-6" style="text-align:center;">
          <h3><i class="fa fa-file-text fa-fw"></i> Ordens de compra </h3>
          <div id="graphOC" style="height: 250px;"></div>                              
        </div>
        
      <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-6" style=""> 
          <h3><i class="fa fa-bullhorn fa-fw"></i> Avisos/Mensagens <span class="badge"><?php echo $result1['QUANTIDADE']; ?>  </span> </h3>
        </div>          
        <div class="col-md-6 col-sm-6 col-xs-6" style="text-align:right;">
          <!--<h3><i class="fa fa-plus fa-fw"></i>  </h3>-->
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
              <table class="table table-hover table-responsive table-condensed">
                <thead>
                  <tr>                                                
                    <th style="width:40%">Remetente</th>                    
                    <th style="width:40%">Assunto</th>                    
                    <th style="width:15%">Data</th>
                    <th style="width:15%">Tipo</th>                    
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
    
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.2/raphael-min.js"></script>
    <script src="assets/js/morris.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/prettify/r224/prettify.min.js"></script>    

    <script>
      var COTsit1 = "<?php echo $sit1 ?>";
      var COTsit2 = "<?php echo $sit2 ?>";
      var COTsit3 = "<?php echo $sit3 ?>";      
      var COTsit5 = "<?php echo $sit5 ?>";
      Morris.Donut({
        element: 'graphCOT',
        data: [
          {value: COTsit1, label: 'Incluidas'},
          {value: COTsit2, label: 'Enviadas'},
          {value: COTsit3, label: 'Retornadas'},          
          {value: COTsit5, label: 'Retornadas - parcial'},
         ],
        colors: [
          '#337AB7',
          '#F0AD4E',
          '#39B580',          
          '#5CB85C'
        ],
        formatter: function (x) { return x + ""}
       }).on('click', function(i, row){
         console.log(i, row);
      });
    </script>
    <script>
      Morris.Donut({
        element: 'graphOC',
        data: [
          {value: 100, label: 'Em desenvolvimento'},          
         ],
        formatter: function (x) { return x + ""}
       }).on('click', function(i, row){
         console.log(i, row);
      });
    </script>    

  </body>
</html>
