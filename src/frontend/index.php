<?php 
  $base = 'http://localhost/teste_crud/src/frontend/'; 
  $base2 = 'http://localhost/teste_crud/src/api/public/';  
?>
<!doctype html>
<html lang="pt-br">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?=$base?>/src/css/bootstrap5.css">
    <title>Power Crud</title>
  </head>
  <body>
  <script type="text/javascript">
    const base = '<?=$base2?>';
    const base2 = '<?=$base?>';
  </script>
  
  <div class='container mt-5'>
    <div class='card text-center'>
        <h1>CRUD Gazin<?=htmlspecialchars('<tech>')?></h1>
    </div>
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
            <button 
            type="button" 
            class="btn btn-primary mb-4 mt-4" 
            onclick="setTipo('Adicionar DEV');fb.limpaCampos();" 
            data-bs-toggle="modal" 
            data-bs-target="#staticBackdrop3"
          >
            Adicionar Dev
          </button>
        </div>
        <div class="col">
            <div class="form-floating">
                <input type="text" class="form-control pesquisa" name="form_txt" placeholder="pesquisa" onkeyup="pesquisa(this.value)" >
                <label for="pesquisa">Digite um Nome Ou ID ..!</label>
            </div>
        </div>
      </div>
      <table class="table mt-3">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Nome</th>
            <th scope="col">Sexo</th>
            <th scope="col">Idade</th>
            <th scope="col">hobby</th>
            <th scope="col">Data de Nascimento</th>
            <th scope="col">Ações</th>
          </tr>
        </thead>
        <tbody id="lista">
            
        </tbody>
      </table>
      <nav aria-label="...">
        <ul class="pagination pagination-sm" id="pagination">
             
        </ul>
      </nav>
    </div>
  </div>



  
<!------modal add cliente----->
<div class="modal fade" id="staticBackdrop3" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title addORedit tt" id="staticBackdropLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <form id="reset" method="POST" enctype="multipart/form-data">
            <div class="row mb-3">
               <div class="col">
                  <div class="form-floating">
                     <input type="text" class="form-control nome" name="form_txt" placeholder="Nome">
                     <label for="Nome">Nome</label>
                  </div>
               </div>
               <div class="col">
                   <div class="form-floating">
                     <select class="sexo form-control" name="form_txt">                    
                           <option value=""></option>
                           <option value="Masculino">Masculino</option>
                           <option value="Feminino">Feminino</option>
                           <option value="Outros">Outros</option>
                        
                     </select>
                     <label for="sexo">Sexo</label>
                  </div>
               </div>
               <div class="col">
                  <div class="form-floating">
                     <input type="text" class="form-control hobby" name="form_txt" placeholder="hobby">
                     <label for="hobby">Hobby</label>
                  </div>
               </div>
            </div>
            <div class="row mb-3">
               <div class="col">
                  <div class="form-floating">
                     <input type="number" class="form-control idade" name="form_txt" placeholder="idade" >
                     <label for="idade">Idade</label>
                  </div>
               </div>
               <div class="col">
                  <div class="form-floating">
                     <input type="date" class="form-control data_nascimento" placeholder="data_nascimento" name="form_txt">
                     <label for="data_nascimento">Data de Nascimento</label>
                  </div>
               </div> 
              
            </div>
         </form>
      </div>
      <div class="modal-footer">
         <input type="hidden" class="edi" value="">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        <button type="button" onclick="add_ou_edit(this)" class="btn btn-primary">Salvar</button>
      </div>
    </div>
  </div>
</div>
<!-- final Modal addcli -->
    <script type="text/javascript" src="<?=$base?>/src/js/jquery.js"></script>
    <script type="text/javascript" src="<?=$base;?>/src/js/script.js"></script>
    <script type="text/javascript" src="<?=$base?>/src/js/bootstrap5.js"></script>
    <script type="text/javascript" src="<?=$base;?>/src/js/sweetalert.js"></script> 
  </body>
</html>
<script>
  var myModal = new bootstrap.Modal(document.getElementById('staticBackdrop3'), {
     keyboard: false
  });
</script>