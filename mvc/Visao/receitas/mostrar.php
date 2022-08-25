 <?php if ($mensagem) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alerts">
        <?= $mensagem ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    </div>
<?php endif ?>

<div class="container">
    <div class="row">
      <div id="login">
        <div id="receitas">


          <div class="card mt-3 div-color-recipe" style="margin: 0 18%">
        <div class="card-header card-color-recipe">
            <a href="<?= URL_RAIZ . 'receitas/' . $receita->getId()?>">
               <p><?= $receita->getNome() ?></p>
           </a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col col-4">
                    <p class="fw-bolder text-uppercase text-muted">Ingredientes:</p>
                    <?= $receita->getIngredientes() ?>
                </div>
                <div class="col col-4">
                    <p class="fw-bolder text-uppercase text-muted">Modo de Preparo:</p>
                    <?= $receita->getPreparo() ?>
                </div>
            </div>
        </div>


        <div class="d-flex justify-content-center">
            <div class="mr-3">
                <a href="<?= URL_RAIZ . 'receitas/' . $receita->getId() . '/editar' ?>" class="card-link btn btn-outline-warning mb-2">Editar</a>
            </div>
            <div>
                

                <form action="<?= URL_RAIZ . 'receitas/' . $receita->getId() ?>" method="post">
                <input type="hidden" name="_metodo" value="DELETE">
            <button id="deletar" type="button" class="btn btn-primary" data-dismiss="modal" onclick="event.preventDefault(); this.parentNode.submit()">Deletar</button>
                </form>


            </div>
        </div>
        <div class="card-footer text-muted footer-color">
            Postada: <?= $receita->getDataReceita() ?> - Usúario <?= $receita->getUsuario()->getEmail() ?>
        </div>
    </div>

          
        </div>
      </div>
    </div>

    <div class="card mt-3 div-color-recipe" style="margin: 0 18%">
        <div class="card-header card-color-recipe">

    <div class="comentarios">
                <h3 class="comentarios-text">Comentários</h3>
                <?php if ($usuarioid == null) : ?>
                    <div class="comentario">
                        <a class="nome-usuario-box-2"href="<?= URL_RAIZ . 'login'?>">
                            <p class="nome-usuario">Você precisa estar logado em uma conta para publicar um comentário!</p>
                        </a>
                    </div>
                <?php endif ?>



                <?php if ($usuarioid != null) : ?>
                    <div class="comentario">
                        <div class="usuario-e-data">
                            <div class="nome-usuario-box">

                                
                                
                                    <p class="nome-usuario">Comentar como: <?= $usuario->getNome() ?></p>

                            </div>
                        </div>
                        <form action="<?= URL_RAIZ . 'receitas/' . $receita->getId() . '/comentarios'?>" method="post">
                            <textarea class="comentar" placeholder="Insira um comentário sobre essa receita!" name="mensagem" cols="40" rows="3"></textarea>
                            <input class="btn bg-pink px-5" type="submit"value="Inserir">
                        </form>
                        <?php if ($mensagem) : ?>
                            <div class="mensagem-alerta">
                                <p><?= $mensagem ?></p>
                            </div>
                        <?php endif ?>



                        <?php if ($this->temErro('mensagem')) : ?>
                            <div class="erro">
                                <p><?= $this->getErro('mensagem') ?></p>
                            </div>
                        <?php endif ?><br>
                    </div>
                <?php endif ?>



                <?php if (empty($comentarios)) : ?>
                    <p class="nao-publicou">Esta receita ainda não contém comentários!</p>
                <?php endif ?>
                <?php foreach ($comentarios as $comentario) : ?>
                    <div class="comentario">
                        <div class="usuario-e-data">
                            <div class="nome-usuario-box">
                        
                                    <div class="card mt-3 div-color-recipe" style="margin: 0 18%">
        <div class="card-header card-color-recipe">

            <p class="nome-usuario">Comentado abaixo por: <?= $comentario->buscarUsuario($comentario->getUsuarioId())->getNome() ?></p>
                            </div>
                        </div>
                        <div class="mensagem-e-lixo">
                            <p class="comentario-usuario"><?= $comentario->getMensagem() ?></p>
                            <?php if ($usuarioid == $comentario->buscarUsuario($comentario->getUsuarioId())->getId()) : ?>

                            <form class="nome-usuario-box-2" method="post" action="<?= URL_RAIZ . 'receitas/' . $receita->getId() . '/comentarios/' . $comentario->getId()?>">
                                <input type="hidden" name="_metodo" value="DELETE">
                                    <input type="hidden" name="idcomentario" value="<?= $comentario->getId() ?>>">
                                    <a href="" onclick="event.preventDefault(); this.parentNode.submit()">Excluir comentário</a>
                                </form>
                            <?php endif ?>


                        </div>
                    </div>
                <?php endforeach ?>

            </div>
             </div>
         </div>
     </div>
 </div>