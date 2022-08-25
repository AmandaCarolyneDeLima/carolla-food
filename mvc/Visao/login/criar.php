 <?php if ($mensagem) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alerts">
        <?= $mensagem ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    </div>
<?php endif ?>


<form action="<?= URL_RAIZ . 'login'?>" method="post" class="mx-4 py-4">
    <div class="py-3">
      <label for="email" class="form-label">Email:</label>
      <input type="email" id="email" name="email" class="form-control" autofocus value="<?= $this->getPost('email') ?>">
      <?php if ($this->temErro('email')) : ?>
                <div class="erro">
                    <p><?= $this->getErro('email') ?></p>
                </div>
            <?php endif ?><br>
    </div>
    
    <div class="py-3">
      <label for="senha" class="form-label">Senha:</label>
      <input type="password" class="form-control" id="senha" name="senha">
            <?php if ($this->temErro('senha')) : ?>
              <div class="erro">
                    <p><?= $this->getErro('senha') ?></p>
                </div>
            <?php endif ?>


            <?php if ($this->temErro('incorreto')) : ?>
              <div class="erro">
                    <p><?= $this->getErro('incorreto') ?></p>
                </div>
            <?php endif ?>
    
    </div>

    <div class="d-grid gap-2 col-6 mx-auto">
      <button class="btn bg-pink px-5" type="submit">Entrar</button>
    </div>
  </form>