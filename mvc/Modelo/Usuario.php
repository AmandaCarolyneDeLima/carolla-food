<?php
namespace Modelo;

use \PDO;
use \Framework\DW3BancoDeDados;
use \Framework\DW3Sessao;

class Usuario extends Modelo {
    const BUSCAR_ID = 'SELECT * FROM usuarios WHERE id = ?';
    const BUSCAR_EMAIL = 'SELECT * FROM usuarios WHERE email = ?';
    const INSERIR = 'INSERT INTO usuarios(nome, email, senha) VALUES (?, ?, ?)';
    const CONTAR_USUARIOS = 'SELECT count(id) FROM usuarios';

    private $id;
    private $nome;
    private $email;
    private $senha;
    private $senhaPlana;

    public function __construct(
        $nome = null,
        $email = null,
        $senha = null,
        //$senhaPlana = null,
        $id = null
    ) {
        $this->nome = $nome;
        $this->email = $email;
        $this->senhaPlana = $senha;
        if ($senha !== null) {
             $this->senha = password_hash($senha, PASSWORD_BCRYPT);
        }
        $this->id = $id;
    }

    //get ID//
    public function getId() {
        return $this->id;
    }

    //get e set NOME//
    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }


    //get e set EMAIL//
    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }



    //SENHA
    public function verificarSenha($senhaPlana) {
        return password_verify($senhaPlana, $this->senha);
    }

    public function salvar() {
        $this->inserir();
    }

    public function inserir() {
        DW3BancoDeDados::getPdo()->beginTransaction();
        $comando = DW3BancoDeDados::prepare(self::INSERIR);
        $comando->bindValue(1, $this->nome, PDO::PARAM_STR);
        $comando->bindValue(2, $this->email, PDO::PARAM_STR);
        $comando->bindValue(3, $this->senha, PDO::PARAM_STR);
        $comando->execute();
        $this->id = DW3BancoDeDados::getPdo()->lastInsertId();
        DW3BancoDeDados::getPdo()->commit();
    }

    public function validarFormularioCriarConta($nome, $email, $senha = null) {
        $erros = [];

        if ($nome && strlen($nome) < 3) {
            $erros['nome'] = 'Por favor, insira um nome com no mínimo 3 caracteres!';
        }
        if (strlen($email) < 5) {
            $erros['email'] = 'Por favor, insira um e-mail com no mínimo 5 caracteres!';
        }
        if (strlen($senha) < 5) {
            $erros['senha'] = 'Por favor, insira uma senha com no mínimo 5 caracteres!';
        }
        return $erros;
    }

    public static function contarUsuarios() {
        $registros = DW3BancoDeDados::query(self::CONTAR_USUARIOS);
        $total = $registros->fetch();
        return intval($total[0]);
    }

    public static function buscarId($id)
    {
        $comando = DW3BancoDeDados::prepare(self::BUSCAR_ID);
        $comando->bindValue(1, $id, PDO::PARAM_INT);
        $comando->execute();
        $registro = $comando->fetch();
        $usuario = null;
        if ($registro) {
            $usuario = new Usuario(
                $registro['nome'],
                $registro['email'],
                null,
                $registro['id']
            );
            $usuario->senha = $registro['senha'];
        }
        return $usuario;
    }

    public static function buscarEmail($email)
    {
        $comando = DW3BancoDeDados::prepare(self::BUSCAR_EMAIL);
        $comando->bindValue(1, $email, PDO::PARAM_STR);
        $comando->execute();
        $registro = $comando->fetch();
        $usuario = null;

        if ($registro) {

            $usuario = new Usuario(
                $registro['nome'],
                $registro['email'],
                null,
                $registro['id']
            );
            $usuario->senha = $registro['senha'];
        }
        return $usuario;
    }
}