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

    public function all() {
        $sql = "SELECT * FROM {$this->table}";
        $all = $this->connect->query($sql);
        $all->execute();

        return $all->fetchAll();
    }

    public function where(array $fieldsValues, $pagina = 0, $orderBy = '') {
        $sql = "SELECT * FROM {$this->table} WHERE 1";
        foreach ($fieldsValues as $field => $value) {
            $sql .= " AND {$field} = '{$value}'";
        }
        // paginação
        if ($orderBy) {
            $sql .= " ORDER BY {$orderBy}";
        }
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

    public function create(array $fieldsValues) {
        $fields = implode(',', array_keys($fieldsValues));
        $values = implode("','", array_values($fieldsValues));
        $sql = "INSERT INTO {$this->table} (create_date, update_date, {$fields}) VALUES (NOW(), NOW(), '{$values}')";
        $sql = str_replace("''", "null", $sql);
        $create = $this->connect->prepare($sql);
        $create->execute();

        return $this->connect->lastInsertId();
    }

    public function update($data) {
        $fields = '';
        foreach ($data as $field => $value) {
            if ($field != $this->primaryKey) {
                $fields .= "{$field} = '{$value}',";
            }
        }
        $fields = substr($fields, 0, -1);
        $sql = "UPDATE {$this->table} SET update_date = NOW(), {$fields} WHERE {$this->primaryKey} = {$data[$this->primaryKey]}";
        $update = $this->connect->prepare($sql);
        $update->execute();

        return $update->rowCount();
    }
}