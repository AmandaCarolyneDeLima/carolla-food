<?php

namespace Modelo;

use \PDO;
use \Framework\DW3BancoDeDados;
use \Framework\DW3ImagemUpload;

class Receita extends Modelo
{
    const BUSCAR_ID = 'SELECT * FROM receitas WHERE id = ?';
    const BUSCAR_AUTOR = 'SELECT * FROM usuarios WHERE usuario_id = ?';
    const INSERIR = 'INSERT INTO receitas(nome, ingredientes, preparo, data_receita, usuario_id) VALUES (?, ?, ?, ?, ?)';
    const ATUALIZAR = 'UPDATE receitas SET nome = ?, ingredientes = ?, preparo = ? WHERE id = ?';
    const BUSCAR_TODOS = 'SELECT * FROM receitas ORDER BY data_receita ';
    const BUSCAR_RECEITAS = 'SELECT * FROM receitas WHERE usuario_id = ';
    const DELETAR = 'DELETE FROM receitas WHERE id = ?';
    const CONTAR_RECEITAS = 'SELECT count(id) FROM receitas';
    const CONTAR_FILTRO = "SELECT count(id) FROM receitas WHERE ingredientes LIKE lower(";
    const CONTAR_FILTRO2 = ")";
    const FILTRAR_INGREDIENTES = "SELECT * FROM receitas WHERE ingredientes LIKE lower(";
    const FILTRAR_INGREDIENTES2 = ") ORDER BY data_receita ";
    const LIMIT_OFFSET = ' LIMIT ? OFFSET ?';

    private $id;
    private $nome;
    private $ingredientes;
    private $preparo;
    private $dataReceita;
    private $usuarioId;
    private $usuario;

    public function __construct(
        $nome = null,
        $ingredientes = null,
        $preparo = null,
        $dataReceita = null,
        $usuarioId = null,
        $usuario = null,
        $receita = null,
        $id = null
    ) {
        $this->id = $id;
        $this->nome = $nome;
        $this->ingredientes = $ingredientes;
        $this->preparo = $preparo;
        $this->setDataReceita($dataReceita);
        $this->usuarioId = $usuarioId;
        $this->usuario = $usuario;
        $this->receita = $receita;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getDataReceita()
    {
        $data = date_create($this->dataReceita);
        return date_format($data, 'd/m/Y');
    }

    public function getIngredientes()
    {
        return $this->ingredientes;
    }

    public function getPreparo()
    {
        return $this->preparo;
    }

    public function getUsuario()
    {
        if ($this->usuario == null) {
            $this->usuario = Usuario::buscarId($this->usuarioId);
        }
        
        return $this->usuario;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getUsuarioId()
    {
        return $this->usuarioId;
    }

     public function setDataReceita($dataReceita)
        {
            if ($dataReceita == null) {
                return null;
            } 
            
            $brasileiro = preg_match('/(\d\d)\/(\d\d)\/(\d\d\d\d)/', $dataReceita, $matches);
            if ($brasileiro) {
                $dataReceita = "$matches[3]-$matches[2]-$matches[1]";
            }
            $this->dataReceita = $dataReceita;
        }


    public function setIngredientes($ingredientes)
    {
        $this->ingredientes = $ingredientes;
    }

    public function setPreparo($preparo)
    {
        $this->preparo = $preparo;
    }

    public function salvar()
    {
        if ($this->id == null) {
            $this->inserir();
        } else {
            $this->atualizar();
        }
    }


    public function inserir()
    {
        DW3BancoDeDados::getPdo()->beginTransaction();
        $comando = DW3BancoDeDados::prepare(self::INSERIR);
        $comando->bindValue(1, $this->nome, PDO::PARAM_STR);
        $comando->bindValue(2, $this->ingredientes, PDO::PARAM_STR);
        $comando->bindValue(3, $this->preparo, PDO::PARAM_STR);
        $comando->bindValue(4, $this->dataReceita, PDO::PARAM_STR);
        $comando->bindValue(5, $this->usuarioId, PDO::PARAM_INT);
        $comando->execute();
        $this->id = DW3BancoDeDados::getPdo()->lastInsertId();
        DW3BancoDeDados::getPdo()->commit();
    }


    public function atualizar()
    {
        $comando = DW3BancoDeDados::prepare(self::ATUALIZAR);
        $comando->bindValue(1, $this->nome, PDO::PARAM_STR);
        $comando->bindValue(2, $this->ingredientes, PDO::PARAM_STR);
        $comando->bindValue(3, $this->preparo, PDO::PARAM_STR);
        $comando->bindValue(4, $this->id, PDO::PARAM_STR);
        $comando->execute();
    }


    public function validarFormularioReceita($nome, $ingredientes, $preparo) {
        $erros = [];

        if (strlen($nome) < 5) {
            $erros['titulo'] = 'No mínimo 5 caracteres são aceitos!';
        }
        if (strlen($ingredientes) < 5) {
            $erros['ingredientes'] = 'No mínimo 5 caracteres são aceitos!';
        }
        if (strlen($preparo) < 5) {
            $erros['passos'] = 'No mínimo 5 caracteres são aceitos!';
        }

        return $erros;
    }


    public static function buscarId($id)
    {
        $comando = DW3BancoDeDados::prepare(self::BUSCAR_ID);
        $comando->bindValue(1, $id, PDO::PARAM_INT);
        $comando->execute();
        $registro = $comando->fetch();

        if ($registro) {
            return new Receita(
                        $registro['nome'],
                        $registro['ingredientes'],
                        $registro['preparo'],
                        $registro['data_receita'],
                        $registro['usuario_id'],
                        null,
                        null,
                        $registro['id'],
                        
            );
        }
    }

     public static function buscarUsuario($usuarioId)
    {
        $comando = DW3BancoDeDados::prepare(self::BUSCAR_AUTOR);
        $comando->bindValue(1, $usuarioId, PDO::PARAM_INT);
        $comando->execute();
        $registro = $comando->fetch();
        return new Usuario(
            $registro['nome'],
            $registro['email'],
            null,
            $registro['id']
        );
    }


    public static function buscarReceitas($limit = 5, $offset = 0, $filtro = null, $ordem = null)
    {
        if ($ordem == null) {
            $ordem = 'DESC';
        }

        if ($filtro) {
        $preComando = self::FILTRAR_INGREDIENTES . "'%" . $filtro . "%'" . self::FILTRAR_INGREDIENTES2 . $ordem . self::LIMIT_OFFSET;
        $comando = DW3BancoDeDados::prepare($preComando);
                $comando->bindValue(1, $limit, PDO::PARAM_INT);
                $comando->bindValue(2, $offset, PDO::PARAM_INT);
                $comando->execute();
                $registros = $comando->fetchAll();
                $receitas=[];

                foreach ($registros as $registro) {
                    $receitas[] = new Receita(
                        $registro['nome'],
                        $registro['ingredientes'],
                        $registro['preparo'],
                        $registro['data_receita'],
                        $registro['usuario_id'],
                        null,
                        null,
                        $registro['id'],
                    );
                }
                return $receitas;
        } else {
        $preComando = self::BUSCAR_TODOS . $ordem . self::LIMIT_OFFSET;
        $comando = DW3BancoDeDados::prepare($preComando);
                $comando->bindValue(1, $limit, PDO::PARAM_INT);
                $comando->bindValue(2, $offset, PDO::PARAM_INT);
                $comando->execute();
                $registros = $comando->fetchAll();
                $receitas=[];

                foreach ($registros as $registro) {
                    $receitas[] = new Receita(
                       $registro['nome'],
                        $registro['ingredientes'],
                        $registro['preparo'],
                        $registro['data_receita'],
                        $registro['usuario_id'],
                        null,
                        null,
                        $registro['id'],
                    );
                }
                return $receitas;
        }
    }





    public static function contarReceitas()
    {
        $registros = DW3BancoDeDados::query(self::CONTAR_RECEITAS);
        $total = $registros->fetch();
        return intval($total[0]);
    }


    public static function contarFiltro($filtro)
        {
            $comando = self::CONTAR_FILTRO . "'%" . $filtro . "%'" . self::CONTAR_FILTRO2;
            $registros = DW3BancoDeDados::query($comando);
            $total = $registros->fetch();
            return intval($total[0]);
        }



    public static function buscarUsuarioReceitas($id)
    {

            $registros = DW3BancoDeDados::query(self::BUSCAR_RECEITAS . $id);
            $receitas=[];

                    foreach ($registros as $registro) {
                        $receitas[] = new Receita(
                        $registro['nome'],
                        $registro['ingredientes'],
                        $registro['preparo'],
                        $registro['data_receita'],
                        $registro['id'],
                        $registro['usuario_id'],
                        );
                    }

                    // var_dump('aaa');
                    // exit();

                    return $receitas;
    }


    public static function destruir($id)
    {
        $comando = DW3BancoDeDados::prepare(self::DELETAR);
        $comando->bindValue(1, $id,  PDO::PARAM_INT);
        $comando->execute();
    }
}
