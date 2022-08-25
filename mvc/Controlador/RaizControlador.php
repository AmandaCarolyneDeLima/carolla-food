<?php
namespace Controlador;

use \Modelo\Receita;
use \Modelo\Usuario;
use \Framework\DW3Sessao;

class RaizControlador extends Controlador
{
    public function index()
    {
        $numeroReceitas = Receita::contarReceitas();
        $numeroUsuarios = Usuario::contarUsuarios();

         $id = DW3Sessao::get('usuario');
        $usuario = Usuario::buscarId($id);

        if ($this->verificarLogado()) {

            $this->visao('home/index.php', [
                                                 'numeroReceitas' => $numeroReceitas,
                                                 'numeroUsuarios' => $numeroUsuarios,
                                                  'usuario' => $usuario,
                                              ],
                                                 'logado.php');
    
        } else {
            $this->visao('home/index.php', [
                                                'numeroReceitas' => $numeroReceitas,
                                                'numeroUsuarios' => $numeroUsuarios,
                                            ],
                                                'index.php');
        }
    }

}
