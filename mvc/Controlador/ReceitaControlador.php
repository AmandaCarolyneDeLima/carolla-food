<?php
namespace Controlador;

use \Modelo\Receita;
use \Modelo\Usuario;
use \Modelo\Comentario;
use \Framework\DW3Sessao;

class ReceitaControlador extends Controlador
{

   
    public function index()
    {
        $paginacao = $this->calcularPaginacao();
        $numeroReceitas = Receita::contarReceitas();
        $numeroUsuarios = Usuario::contarUsuarios();

        $id = DW3Sessao::get('usuario');
        $usuario = Usuario::buscarId($id);

        if ($this->verificarLogado()) {

            $this->visao('receitas/index.php', ['receitas' => $paginacao['receitas'],
                                                 'pagina' => $paginacao['pagina'],
                                                 'ultimaPagina' => $paginacao['ultimaPagina'],
                                                 'filtro' => $paginacao['filtro'],
                                                 'ordem' => $paginacao['ordem'],
                                                 'numeroReceitas' => $numeroReceitas,
                                                 'numeroUsuarios' => $numeroUsuarios,
                                                  'usuario' => $usuario,
                                                  'mensagem' => DW3Sessao::getFlash('mensagem', null),
                                              ],
                                                 'logado.php');
    
        } else {
            $this->visao('receitas/index.php', ['receitas' => $paginacao['receitas'],
                                                'pagina' => $paginacao['pagina'],
                                                'ultimaPagina' => $paginacao['ultimaPagina'],
                                                'filtro' => $paginacao['filtro'],
                                                'ordem' => $paginacao['ordem'],
                                                'usuarioid' => DW3Sessao::get('usuario'),
                                                'numeroReceitas' => $numeroReceitas,
                                                'numeroUsuarios' => $numeroUsuarios,
                                                'mensagem' => DW3Sessao::getFlash('mensagem', null),
                                            ],
                                                'index.php');
        }
    }

    





    public function filtrar($filtro = null, $ordem = null)
        {
            if ($filtro == null && $ordem == null) {
                $paginacao = $this->calcularPaginacao($_POST['filtro'], $_POST['ordem']);
            } else {
                $paginacao = $this->calcularPaginacao($filtro, $ordem);
            }

            $numeroReceitas = Receita::contarReceitas();
            $numeroUsuarios = Usuario::contarUsuarios();

            if ($this->verificarLogado()) {
                $this->visao('receitas/index.php', ['receitas' => $paginacao['receitas'],
                                                    'pagina' => $paginacao['pagina'],
                                                    'ultimaPagina' => $paginacao['ultimaPagina'],
                                                    'filtro' => $paginacao['filtro'],
                                                    'ordem' => $paginacao['ordem'],
                                                    'usuarioid' => DW3Sessao::get('usuario'),
                                                    'numeroReceitas' => $numeroReceitas,
                                                    'numeroUsuarios' => $numeroUsuarios,
                                                'mensagem' => DW3Sessao::getFlash('mensagem', null),
                                            ],
                                                    'logado.php');
            } else {
                $this->visao('receitas/index.php', ['receitas' => $paginacao['receitas'],
                                                     'pagina' => $paginacao['pagina'],
                                                     'ultimaPagina' => $paginacao['ultimaPagina'],
                                                     'filtro' => $paginacao['filtro'],
                                                     'ordem' => $paginacao['ordem'],
                                                     'numeroReceitas' => $numeroReceitas,
                                                     'numeroUsuarios' => $numeroUsuarios,
                                                 'mensagem' => DW3Sessao::getFlash('mensagem', null),
                                             ],
                                                     'index.php');
            }
        }



    public function criar()
    {
        if ($this->verificarLogado()) {
            $this->visao('receitas/criar.php', [
                'usuario' => $this->getUsuario(),
                'mensagem' => DW3Sessao::getFlash('mensagem', null),
                'usuarioid' => DW3Sessao::get('usuario')
                ], 'logado.php');
        } else {
            DW3Sessao::setFlash('mensagem', 'Você precisa estar cadastrado para inserir uma receita!');
            $this->redirecionar(URL_RAIZ . 'login');
        }
    }



    public function armazenar()
    {
        $this->verificarLogado();

        $receita = new Receita(
            $_POST['nome'],
            $_POST['ingredientes'],
            $_POST['preparo'],
            date('d/m/Y'),
            //$_POST['dataReceita'],
            DW3Sessao::get('usuario'),
        );


        $this->setErros($receita->validarFormularioReceita($_POST['nome'], $_POST['ingredientes'], $_POST['preparo']));

        if ($this->getErro('nome') || $this->getErro('ingredientes') || $this->getErro('preparo')){
            $this->visao('receitas/criar.php', ['mensagem' => DW3Sessao::getFlash('mensagem', null), 'usuarioid' => DW3Sessao::get('usuario')], 'logado.php');
         }
       else {
           $receita->salvar();
           DW3Sessao::setFlash('mensagem', 'Receita inserida com sucesso!');
           $this->redirecionar(URL_RAIZ . 'receitas');
       }
     }

    



    //metodo mostrar receita

     public function mostrar($id) {
        $receita = Receita::buscarId($id);
        $comentarios = Comentario::buscarComentarios($id);

        $usuario = Usuario::buscarId(DW3Sessao::get('usuario'));

        if ($receita == null) {
            $this->redirecionar(URL_RAIZ . 'receitas');
        }

        if ($this->verificarLogado()) {
            $this->visao('receitas/mostrar.php', [
                'comentarios' => $comentarios,
                'receita' => $receita,
                'mensagem' => DW3Sessao::getFlash('mensagem', null),
                'usuarioid' => DW3Sessao::get('usuario'),
                'usuario' => $usuario
                ], 'logado.php');
        } else {
            $this->visao('receitas/mostrar.php', [
                'comentarios' => $comentarios,
                'receita' => $receita,
                'mensagem' => DW3Sessao::getFlash('mensagem', null),
                'usuarioid' => DW3Sessao::get('usuario')
                ], 'index.php');
        }
    }


    public function atualizar($id) {
        $receita = new Receita(
            $_POST['nome'],
            $_POST['ingredientes'],
            $_POST['preparo'],
            null,
            null,
            null,
            null,
            $id
        );

        $this->setErros($receita->validarFormularioReceita($_POST['nome'], $_POST['ingredientes'], $_POST['preparo']));

        if ($this->getErro('nome') || $this->getErro('ingredientes') || $this->getErro('preparo')) {
             $this->visao('receitas/editar.php', ['mensagem' => DW3Sessao::getFlash('mensagem', null),
                         'usuarioid' => DW3Sessao::get('usuario'), 'receita' => $receita], 'logado.php');
        } else {
            $confirmacao = Receita::buscarId($id)->getUsuarioId();
            if (DW3Sessao::get('usuario') == $confirmacao) {
                $receita->salvar();
                DW3Sessao::setFlash('mensagem', 'Receita atualizada com sucesso!');
                $this->redirecionar(URL_RAIZ . 'receitas');
                //$this->redirecionar(URL_RAIZ . 'receitas/' . $receita->getId() . '/editar');
            } else {
                $this->redirecionar(URL_RAIZ . 'receitas');
            }
        }
    }


    public function editar($id)
    {
        $receita = Receita::buscarId($id);



        if (DW3Sessao::get('usuario') == $receita->getUsuarioId()) {
            $this->visao('receitas/editar.php', ['mensagem' => DW3Sessao::getFlash('mensagem', null),
            'usuarioid' => DW3Sessao::get('usuario'), 'receita' => $receita], 'logado.php');
        } 
        else {
            DW3Sessao::setFlash('mensagem', 'Você não pode editar as receitas de outros usuários!');
            $this->redirecionar(URL_RAIZ . 'receitas');
        }
        
    }



    

     public function destruir($id)
    {
        $this->verificarLogado();
        $receita = Receita::buscarId($id);

        if ($receita->getUsuarioId() == $this->getUsuario()->getId()) {
            Receita::destruir($id);
            DW3Sessao::setFlash('mensagem', 'Receita deletada!');
        } else {
            DW3Sessao::setFlash('mensagem', 'Você não pode deletar receitas de outros usuários!');
        }
        $this->redirecionar(URL_RAIZ . 'receitas');
    }


    //todas receitas
    public function calcularPaginacao($filtro = null, $ordem = null, $id = null) {
        $pagina = array_key_exists('p', $_GET) ? intval($_GET['p']) : 1;
        $limit = 5;
        $offset = ($pagina - 1) * $limit;

        if ($id) {
            $receitas = Receita::buscarUsuarioReceitas($id);

        } else {
            $receitas = Receita::buscarReceitas($limit, $offset, $filtro, $ordem);
        }

        if ($filtro != null) {
            $ultimaPagina = ceil(Receita::contarFiltro($filtro) / $limit);
        } else {
            $ultimaPagina = ceil(Receita::contarReceitas() / $limit);
        }
        return compact('filtro', 'ordem', 'pagina', 'receitas', 'ultimaPagina');
    }


}
