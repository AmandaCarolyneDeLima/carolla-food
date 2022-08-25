<?php
namespace Controlador;

use \Modelo\Usuario;
use \Modelo\Receita;
use \Framework\DW3Sessao;

class UsuarioControlador extends Controlador
{
    public function criar() {
        //$this->verificarLogado()
        $id = DW3Sessao::get('usuario');
        $usuario = Usuario::buscarId($id);

        if ($this->verificarLogado()) {

            $this->visao('usuarios/criar.php', [
                                                  'usuario' => $usuario,
                                                  'mensagem' => DW3Sessao::getFlash('mensagem')
                                              ],
                                                 'logado.php');
    
        } else {
            $this->visao('usuarios/criar.php', [
                'mensagem' => DW3Sessao::getFlash('mensagem')
                                            ],
                                                'index.php');
        }
    }

    public function armazenar()
    {
        $usuario = new Usuario($_POST['nome'], $_POST['email'], $_POST['senha']);
        //$usuario2 = Usuario::buscarEmail($_POST['email']);

        $this->setErros($usuario->validarFormularioCriarConta($_POST['nome'], $_POST['email'], $_POST['senha']));

        if ($usuario->isValido()) {
            $usuario->salvar();
            DW3Sessao::set('usuario', $usuario->getId());
            DW3Sessao::setFlash('mensagem', 'Usuário cadastrado com sucesso!');
            $this->redirecionar(URL_RAIZ . 'receitas');

        } else {
            $this->setErros($usuario->getValidacaoErros());
            $this->visao('usuarios/criar.php');
        }
    }

    public function mostrar($id)
    {
        $usuario = Usuario::buscarId($id);
        $receitas = Receita::buscarUsuarioReceitas($id);

        if ($this->verificarLogado()) {
            $this->visao('usuarios/mostrar.php', [
                'usuario' => $usuario,
                'usuarioid' => DW3Sessao::get('usuario'),
                'receitas' => $receitas
            ], 'logado.php');
        } else {
            $this->visao('usuarios/mostrar.php', [
            'usuario' => $usuario,
            'usuarioid' => DW3Sessao::get('usuario'),
            'receitas' => $receitas
            ], 'index.php');
        }

    }
}