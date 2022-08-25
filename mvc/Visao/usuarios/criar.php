<?php if ($mensagem) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alerts">
        <?= $mensagem ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    </div>
<?php endif ?>

<form action="<?= URL_RAIZ . 'usuarios/criar'?>" method="post" class="mx-4 py-4">
    <div class="py-3">
      <label for="inputUserName" class="form-label">Nome</label>
      <input type="text" class="form-control" id="inputUserName" name="nome" />
    </div>
    
    <div class="py-3">
      <label for="inputEmail" class="form-label">E-mail</label>
      <input type="email" class="form-control" id="inputEmail" name="email">

    </div>

    <div class="py-3">
      <label for="inputPassword" class="form-label">Senha</label>
      <input type="password" class="form-control" id="inputPassword" name="senha">

    </div>

    <div class="d-grid gap-2 col-6 mx-auto">
      <button class="btn bg-pink px-5" type="submit">Salvar</button>
    </div>
  </form>