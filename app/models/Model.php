<?php

namespace app\models;


class Model{

    protected $connect;
    protected $table = '';
    protected $range = 0;

    public function __construct()
    {
        $this->connect = Connection::connect();
    }

    public function all() {
        $sql = "SELECT * FROM {$this->table}";
        $all = $this->connect->query($sql);
        $all->execute();

        return $all->fetchAll();
    }

    public function where(array $fieldsValues, $pagina = 0) {
        $sql = "SELECT * FROM {$this->table} WHERE 1";
        foreach ($fieldsValues as $field => $value) {
            $sql .= " AND {$field} = '{$value}'";
        }
        // paginação
        if ($this->range > 0 && $pagina) {
			$sql .= " LIMIT {$pagina}, {$this->range}";
		}
        $where = $this->connect->query($sql);
        $where->execute();

        return $where->fetchAll();
    }

    public function count(array $fieldsValues) {
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE 1";
        foreach ($fieldsValues as $field => $value) {
            $sql .= " AND {$field} = '{$value}'";
        }
        $count = $this->connect->query($sql);
        $count->execute();

        return $count->fetchColumn();
    }

    public function find(int $id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = {$id}";
        $find = $this->connect->query($sql);
        $find->execute();

        return $find->fetch();
    }

    public function gerRange()
    {
        return $this->range;
    }
}