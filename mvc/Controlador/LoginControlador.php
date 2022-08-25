<?php
namespace Controlador;

use \Modelo\Usuario;
use \Framework\DW3Sessao;

class LoginControlador extends Controlador
{
    public function criar()
    {
        $this->visao('login/criar.php', ['mensagem' => DW3Sessao::getFlash('mensagem', null)]);

    }

    public function armazenar()
    {
        $erros = [];

        if (strlen($_POST['email']) < 3) {
            $erros['email'] = 'Por favor, insira um e-mail com no mínimo 5 caracteres!';
        }
        if (strlen($_POST['senha']) < 3) {
            $erros['senha'] = 'Por favor, insira uma senha com no mínimo 5 caracteres!';
        }
        $this->setErros($erros);

        if ($this->getErro('email') || $this->getErro('senha')) {
            $this->visao('login/criar.php', ['mensagem' => DW3Sessao::getFlash('mensagem', null)], 'index.php');
        } else {
            $usuario = Usuario::buscarEmail($_POST['email']);
            //var_dump($usuario);

            if ($usuario && $usuario->verificarSenha($_POST['senha'])) {
                
                DW3Sessao::set('usuario', $usuario->getId());
                $this->redirecionar(URL_RAIZ . 'receitas');
            } else {
                $erros['incorreto'] = 'E-mail ou senha incorreta.';
                $this->setErros($erros);
                $this->visao('login/criar.php', ['mensagem' => DW3Sessao::getFlash('mensagem', null)], 'index.php');
            }
        }
    }

    public function destruir()
    {
        DW3Sessao::deletar('usuario');
        $this->redirecionar(URL_RAIZ . 'login');
    }
}