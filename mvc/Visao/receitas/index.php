<?php if ($mensagem) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alerts">
        <?= $mensagem ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    </div>
<?php endif ?>


<div class="container">
    <div class="row">
      <div id="login">
        <form method="post" action="<?= URL_RAIZ . 'index'?>"> 

          <div id="minhasreceitas">

            <div class="row d-flex justify-content-center">
              
              <div class="col-md-8">

               


<?php foreach ($receitas as $receita) : ?>


    <div class="card mt-3 div-color-recipe" style="margin: 0 18%">
        <div class="card-header card-color-recipe">
            <a href="<?= URL_RAIZ . 'receitas/' . $receita->getId()?>">
               <p><?= $receita->getNome() ?></p>
           </a>
        </div>
       

        <p>Clique no nome da receita para ver sua descrição!</p>

        
        <div class="card-footer text-muted footer-color">
            Postada: <?= $receita->getDataReceita() ?> - Usúario <?= $receita->getUsuario()->getEmail() ?>
        </div>
    </div>

<?php endforeach ?>

  


    <nav aria-label="Page navigation" class="my-4">
      <ul class="pagination justify-content-end">
        <?php if ($ordem == null && $filtro == null) : ?>
    <div class="paginacao">
        <?php if ($pagina > 1) : ?>
            <a class="paginacao-button-avancar" href="<?= URL_RAIZ . 'receitas?p=' . ($pagina-1) ?>">Retornar uma página</a>
        <?php endif ?>
        <?php if ($pagina < $ultimaPagina) : ?>
            <a class="paginacao-button-voltar" href="<?= URL_RAIZ . 'receitas?p=' . ($pagina+1) ?>">Avançar uma página</a>
        <?php endif ?>
    </div>
<?php endif ?>



<?php if ($ordem != null || $filtro != null) : ?>
    <div class="paginacao">
        <?php if ($pagina > 1) : ?>
            <form class="paginacao-form" action="<?= URL_RAIZ . 'receitas/filtrar?p=' . ($pagina-1) ?>" method="post">
                <input hidden name="filtro" value="<?=$filtro?>">
                <input hidden name="ordem" value="<?=$ordem?>">
                <button class="paginacao-button-voltar" type="submit">Retornar uma página</button>
            </form>
        <?php endif ?>




        
        <?php if ($pagina < $ultimaPagina) : ?>
            <form class="paginacao-form" action="<?= URL_RAIZ . 'receitas/filtrar?p=' . ($pagina+1) ?>" method="post">
                <input hidden name="filtro" value="<?=$filtro?>">
                <input hidden name="ordem" value="<?=$ordem?>">
                <button class="paginacao-button-avancar" type="submit">Avançar uma página</button>
            </form>
        <?php endif ?>
    </div>
<?php endif ?>
      </ul>
    </nav>
