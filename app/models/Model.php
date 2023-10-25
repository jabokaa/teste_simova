<?php

namespace app\models;


class Model{

    protected $connect;
    protected $table = '';
    protected $range = 0;

    protected $primaryKey = 'id';

    public function __construct()
    {
        $this->connect = Connection::connect();
    }

    /*
    * Retorna todos os registros da tabela
    * @return array
    */
    public function all(): array {
        $sql = "SELECT * FROM {$this->table}";
        $all = $this->connect->query($sql);
        $all->execute();
        $result = $all->fetchAll();
        return $result ? $result : []; 
    }

    /**
     * Retorna os registros da tabela de acordo com os filtros
     * @param array $fieldsValues
     * @param int $page pagina atual do paginador
     * @param string $orderBy campo para ordenação
     * @return array
     */
    public function where(array $fieldsValues, int $page = 1, string $orderBy = '') {
        $sql = "SELECT * FROM {$this->table} WHERE 1";
        foreach ($fieldsValues as $field => $value) {
            $sql .= " AND {$field} = '{$value}'";
        }
        // paginação
        if ($orderBy) {
            $sql .= " ORDER BY {$orderBy}";
        }
        if ($this->range > 0) {
            $page = $page ? $page : 1; 
            $index = ($page - 1) * $this->range;
			$sql .= " LIMIT {$index}, {$this->range}";
		}


        $where = $this->connect->query($sql);
        $where->execute();
        $result = $where->fetchAll();
        return $result ? $result : [];
    }

    /**
     * Retorna a quantidade de registros da tabela de acordo com os filtros
     * @param array $fieldsValues
     * @return int
     */
    public function count(array $fieldsValues) {
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE 1";
        foreach ($fieldsValues as $field => $value) {
            $sql .= " AND {$field} = '{$value}'";
        }
        $count = $this->connect->query($sql);
        $count->execute();

        return $count->fetchColumn();
    }

    /**
     * Retorna o registro da tabela de acordo com o id
     * @param int $id
     * @return array
     */
    public function find(int $id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = {$id}";
        $find = $this->connect->query($sql);
        $find->execute();
        $result = $find->fetch();
        return $result ? $result : [];
    }

    /**
     * Retorna a quantidade exibida por pagina
     * @return int
     */
    public function gerRange(): int
    {
        return $this->range;
    }

    /**
     * Cria um novo registro na tabela
     * @param array $fieldsValues
     * @return int
     */
    public function create(array $fieldsValues): int {
        $fields = implode(',', array_keys($fieldsValues));
        $values = implode("','", array_values($fieldsValues));
        $sql = "INSERT INTO {$this->table} (create_date, update_date, {$fields}) VALUES (NOW(), NOW(), '{$values}')";
        $sql = str_replace("''", "null", $sql);
        $create = $this->connect->prepare($sql);
        $create->execute();

        return $this->connect->lastInsertId();
    }

    /**
     * Atualiza um registro na tabela
     * @param array $data
     * @return int
     */
    public function update(array $data) {
        $fields = '';
        foreach ($data as $field => $value) {
            if ($field != $this->primaryKey) {
                $fields .= "{$field} = '{$value}',";
            }
        }
        $fields = substr($fields, 0, -1);
        $sql = "UPDATE {$this->table} SET update_date = NOW(), {$fields} WHERE {$this->primaryKey} = {$data[$this->primaryKey]}";
        $sql = str_replace("''", "null", $sql);
        $update = $this->connect->prepare($sql);
        $update->execute();

        return $update->rowCount();
    }
}