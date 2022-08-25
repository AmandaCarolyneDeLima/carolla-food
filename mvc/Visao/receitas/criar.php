 <?php if ($mensagem) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alerts">
        <?= $mensagem ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    </div>
<?php endif ?>



<div class="row d-flex justify-content-center">

    <div class="col-md-8">

      <form action="<?= URL_RAIZ . 'receitas/criar'?>" method="post" enctype="multipart/form-data" class="mx-4 py-4">
        <div class="py-3">
          <label for="nome-receita" class="form-label">Nome da receita</label>
          <input type="text" class="form-control" id="nome-receita" name="nome" value="<?= $this->getPost('nome') ?>">
          <?php if ($this->temErro('nome')) : ?>
                        <div class="erro">
                            <p><?= $this->getErro('nome') ?></p>
                        </div>
                    <?php endif ?><br>
        </div>




        <div class="py-3">
          <label for="ingredientes" class="form-label">Ingredientes</label>
          <textarea class="form-control" id="ingredientes" rows="4" name="ingredientes"><?= $this->getPost('ingredientes') ?></textarea>
          <?php if ($this->temErro('ingredientes')) : ?>
                        <div class="erro">
                            <p><?= $this->getErro('ingredientes') ?></p>
                        </div>
                    <?php endif ?><br>
        </div>




        <div class="py-3">
          <label for="preparo" class="form-label">Modo de preparo</label>
          <textarea class="form-control" id="preparo" rows="4" name="preparo"><?= $this->getPost('preparo') ?></textarea>
          <?php if ($this->temErro('preparo')) : ?>
                        <div class="erro">
                            <p><?= $this->getErro('preparo') ?></p>
                        </div>
                    <?php endif ?><br>
        </div>


         <div class="d-grid gap-2 col-6 mx-auto">
      <button class="btn bg-pink px-5" type="submit">Cadastrar</button>
    </div>

      </form>

    </div>
  </div>

</form>