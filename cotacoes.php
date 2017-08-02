<?php
require_once("assets/php/class.seg.php");
session_start();
proteger();

$host="10.0.0.2";
$service="//10.0.0.2:1521/orcl";
$conn= new \PDO("oci:host=$host;dbname=$service","PORTAL","aN1G3rp4I#");

$usuario=$_SESSION['usuarioEmail'];

$queryQNT="SELECT COUNT(CODIGO) AS QUANTIDADE FROM PO_COTACOES WHERE USUARIO=:usuario";
$queryCOT="SELECT COT.*, SIT.DESCRICAO AS DESC_SIT, SIT.LABEL FROM PO_COTACOES COT, PO_SITUACOES SIT WHERE COT.SITUACAO = SIT.CODIGO AND USUARIO= :usuario ORDER BY COT.CODIGO ASC";


//  Quantidade cotações
$stmtQNT=$conn->prepare($queryQNT);
$stmtQNT->bindValue(':usuario',$usuario);
$stmtQNT->execute();
$resultQNT=$stmtQNT->fetch(PDO::FETCH_ASSOC);

//  Cotações
$stmtCOT=$conn->prepare($queryCOT);
$stmtCOT->bindValue(':usuario',$usuario);
$stmtCOT->execute();
$resultCOT=$stmtCOT->fetchAll(PDO::FETCH_ASSOC);



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

    <title>Cota&ccedil;&otilde;es - Portal Aniger</title>

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
            <li class="active"> <a href="cotacoes.php"><i class="fa fa-list-alt fa-fw"></i> Cota&ccedil;&otilde;es</a></li>
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
          <h3><i class="fa fa-list-alt fa-fw"></i> Cota&ccedil;&otilde;es <span class="badge"><?php echo $resultQNT['QUANTIDADE']; ?>  </span> </h3>
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
                    <th style="width:5%">Cota&ccedil;&atilde;o</th>                    
                    <th style="width:10%">Material</th>
                    <th style="width:55%">Descri&ccedil;&atilde;o</th>                                                            
                    <th style="width:10%">Fornecedores</th>                    
                    <th style="width:8%">Cria&ccedil;&atilde;o</th>
                    <th style="width:15%">Situa&ccedil;&atilde;o</th>                    
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $rr=1;
                  foreach ($resultCOT as $keyCOT => $value) {

                    $cotacao=$resultCOT[$keyCOT]['CODIGO'];

                    $queryFO="SELECT COT.*, MAT.NOME, SIT.DESCRICAO AS DESC_SITUACAO, SIT.ALERT, GFORN.CODIGO AS COD_FORNECEDOR, GFORN.APELIDO, GFORN.NOME AS RAZAO_SOCIAL, CONT.NOME AS CONTATO, CONT.EMAIL AS EMAIL_CONTATO FROM PO_COTACOES_FORNECEDORES FORN, PO_COTACOES COT,PO_SITUACOES SIT, ANIGER.TAB000012 GFORN, ANIGER.TAB000035 CONT, ANIGER.EST010007 MAT WHERE FORN.COTACAO = COT.CODIGO AND FORN.SITUACAO = SIT.CODIGO AND FORN.FORNECEDOR = GFORN.CODIGO AND CONT.FORNECEDOR = FORN.FORNECEDOR AND COT.MATERIAL = MAT.CODIGO(+) AND CONT.RECEBE_COTACAO_COMPRA = 'S'AND FORN.COTACAO =:cotacao";

                    $stmtFO=$conn->prepare($queryFO);                    
                    $stmtFO->bindValue(':cotacao',$cotacao);
                    $stmtFO->execute();                    
                    $resultFO=$stmtFO->fetchAll(PDO::FETCH_ASSOC);

                    echo '
                      <tr>                                                        
                        <td align="middle"> <span data-toggle="modal" data-target="#'.$resultCOT[$keyCOT]['CODIGO'].'DETModal"><a style="text-decoration:none;" href="#" title="Detalhes">'.$resultCOT[$keyCOT]['CODIGO'].' <i class="fa fa-list-alt"></i></a></span></td>
                        <td>                <span>'.$resultCOT[$keyCOT]['MATERIAL'].'</span></td>
                        <td>                <span>'.$resultCOT[$keyCOT]['DESC_MATERIAL'].'</span></td>
                        <td align="middle"> <span data-toggle="modal" data-target="#'.$resultCOT[$keyCOT]['CODIGO'].'FOModal"><a href="#" title="Fornecedores"><i class="fa fa-users"></i></a></span></td>
                        <td>                <span>'.$resultCOT[$keyCOT]['DATA_CRIACAO'].'</span></td>
                        <td>                <span class="'.$resultCOT[$keyCOT]['LABEL'].'">'.$resultCOT[$keyCOT]['DESC_SIT'].'</span></td>                                                                                                                      
                      </tr>

                      <!-- MODAL FORNECEDORES -->
                      <div class="modal fade" id="'.$resultCOT[$keyCOT]['CODIGO'].'FOModal" tabindex="-1" role="dialog" aria-labelledby="'.$resultCOT[$keyCOT]['CODIGO'].'FOModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header" style="text-align:center; color:grey;">                            
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                              <br>
                              <i class="fa fa-list-alt fa-4x"></i> 
                              <h5 style="margin-bottom:0;" id="SEModalLabel" class="bold">Material: '.$resultCOT[$keyCOT]['DESC_MATERIAL'].'</h5>                                                            
                            </div>
                            <div class="modal-body">
                              <div class="">
                                <div class="row" style="line-height:2;">

                                  <div class="col-md-12">';

                                    foreach ($resultFO as $keyFO => $value) {
                                      echo '
                                      
                                        <div class="'.$resultFO[$keyFO]['ALERT'].'" role="alert">
                                          <div class="row">
                                            <div class="col-md-8">
                                              <strong>Fornecedor:</strong> '.$resultFO[$keyFO]['APELIDO'].'
                                            </div>
                                            <div class="col-md-4">
                                              <strong>Status:</strong> '.$resultFO[$keyFO]['DESC_SITUACAO'].'
                                            </div>
                                            <div class="col-md-5">
                                              <strong>Contato:</strong> '.$resultFO[$keyFO]['CONTATO'].'
                                            </div>
                                            <div class="col-md-7">
                                              <strong>Email:</strong> '.$resultFO[$keyFO]['EMAIL_CONTATO'].'
                                            </div>                                
                                          </div>                                
                                                                                
                                        </div>'
                                    ;}

                                                             
                                    echo '
                                                                    
                                  </div>

                                  <div class="col-md-12">                                                                                                                                      
                                  </div>                                      
                                  
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- MODAL DETALHES -->
                      <div class="modal fade" id="'.$resultCOT[$keyCOT]['CODIGO'].'DETModal" tabindex="-1" role="dialog" aria-labelledby="'.$resultCOT[$keyCOT]['CODIGO'].'DETModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header" style="text-align:center; color:grey;">                            
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                              <br>
                              <i class="fa fa-list-alt fa-4x"></i> 
                              <h5 style="margin-bottom:0;" id="SEModalLabel" class="bold">Material: '.$resultCOT[$keyCOT]['DESC_MATERIAL'].'</h5>                                                            
                            </div>
                            <div class="modal-body">
                              <div class="">
                                <div class="row" style="line-height:2;">

                                  <div class="col-md-12">';

                                    

                                                             
                                    echo '
                                                                    
                                  </div>

                                  <div class="col-md-12">                                                                                                                                      
                                  </div>                                      
                                  
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

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

      <!-- MODAL SENHA -->
      <div class="modal fade" id="SEModal" tabindex="-1" role="dialog" aria-labelledby="SEModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header" style="text-align:center; color:grey;">
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
