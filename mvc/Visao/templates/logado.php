<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Carolla Food</title>

  <!-- Boostrap Styles -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- CSS Styles -->
  <link rel="stylesheet" href="<?= URL_CSS . 'principal.css'?>">
</head>

<!----------------------------------------------------------------------------------------------------------------->

<body>

  <header>

    <nav class="navbar navbar-expand-lg navbar-light bg-pink px-4">
      <div class="container-fluid">
        <a class="navbar-brand" href="<?= URL_RAIZ?>">CAROLLA FOOD</a>
        <div class="d-flex">

          <ul class="navbar-nav">
            <form class="d-flex" method="get">
              
              <!-- <select class="form-select form-select-sm" id="specificSizeSelect">
                <option selected>Ordenar data crescente</option>
                <option selected>Ordenar data decrescente</option>
              </select>


                    <form class="d-flex">
                       <input class="form-control me-2" type="search" placeholder="Buscar receitas" aria-label="Search" name="buscar">
                         <button class="btn btn-outline-success" type="submit">Buscar</button>
                    </form> -->
 </form>



                    <div class="filtrar">
    <form action="<?= URL_RAIZ . 'receitas/filtrar'?>" method="post">
        <input type="text" name="filtro" placeholder="Filtrar por ingrediente" value="<?= ($this->getPost('filtro') != null) ? $this->getPost('filtro') : '' ?>">
        <label for="ordem">e por:</label>
        <select name="ordem" id="ordem">
           <option value="DESC">Data Decrescente</option>
           <option <?= ($this->getPost('ordem') != null && $this->getPost('ordem') == 'ASC') ? 'selected' : '' ?> value="ASC">Data Crescente</option>
        </select>
        <input class="submit" type="submit" value="Filtrar">
    </form>
</div>



              <!-- <input class="form-control me-2" type="search" name="buscar" placeholder="Buscar receitas">

              <button class="btn bg-white" type="submit">Buscar</button> -->

           

             <li class="nav-item"> <a class="nav-link" href="<?= URL_RAIZ . 'receitas'?>">Receitas</a> </li>
            <li class="nav-item"> <a class="nav-link" href="<?= URL_RAIZ . 'usuarios/criar'?>">Cadastre-se</a> </li>
            <li class="nav-item"> <a class="nav-link" href="<?= URL_RAIZ . 'receitas/criar'?>">Cadastrar receitas</a> </li>
            
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?= $this->getUsuario()->getNome() ?></a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li>
                <form action="<?= URL_RAIZ . 'login' ?>" method="post">
                                <input type="hidden" name="_metodo" value="DELETE">
                                <button type="submit" class="btn btn-default btn-block dropdown-item text-muted" size >Sair</button>
                              </form>
              </li>
            </ul>
            </li>
          </ul>
          
        </div>
      </div>
    </nav>

  </header>


   <?php $this->imprimirConteudo() ?>



  <!----------------------------------------------------------------------------------------------------------------->

<!-- Boostrap script -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>