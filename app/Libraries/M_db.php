<?php

/**
 * Minang Igniter
 *
 * Engine code untuk pengembangan aplikasi berbasis codeigniter
 * @link	http://ilmuprogrammer.com
 *
 * M_db
 *
 * Librari ini digunakan untuk memudahkan penggunaan query builder CodeIgniter.
 * Diporting ke API CodeIgniter 4.
 *
 * @copyright	Copyright (c) 2015 Heru Rahmat Akhnuari
 * @version 	1.0
 **/

namespace App\Libraries;

use App\Compat\Registry;
use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Database\BaseConnection;

defined('BASEPATH') OR exit('No direct script access allowed');

class M_db
{
    /** @var BaseConnection */
    protected $db;

    public function __construct()
    {
        $this->db = Registry::db();
    }

    /**
     * @return BaseConnection
     */
    public function connection()
    {
        return $this->db;
    }

    protected function builder(string $table): BaseBuilder
    {
        return $this->db->table($table);
    }

    /**
     * Apply a CI3 style order string, e.g. "nama ASC, id DESC".
     */
    protected function applyOrder(BaseBuilder $builder, $order): void
    {
        if (empty($order)) {
            return;
        }

        foreach ((array) $order as $single) {
            foreach ($this->splitOrder((string) $single) as $chunk) {
                $chunk = trim($chunk);
                if ($chunk === '') {
                    continue;
                }

                if (preg_match('/^(.+?)\s+(ASC|DESC)$/i', $chunk, $matches)) {
                    $builder->orderBy(trim($matches[1]), strtoupper($matches[2]));
                } else {
                    $builder->orderBy($chunk);
                }
            }
        }
    }

    /**
     * @return array<int, string>
     */
    protected function splitOrder(string $order): array
    {
        $parts   = [];
        $current = '';
        $depth   = 0;

        foreach (str_split($order) as $char) {
            if ($char === '(') {
                $depth++;
            } elseif ($char === ')') {
                $depth--;
            }

            if ($char === ',' && $depth === 0) {
                $parts[] = $current;
                $current = '';
                continue;
            }

            $current .= $char;
        }

        if (trim($current) !== '') {
            $parts[] = $current;
        }

        return $parts;
    }

    public function noTable()
    {
        throw new \RuntimeException('Gunakan nama table terlebih dahulu pada parameter');
    }

    public function get_data($table, $where = [], $order = '', $group = '', $limit = null, $start = null)
    {
        if (empty($table)) {
            $this->noTable();
        }

        $builder = $this->builder($table);

        if (! empty($where)) {
            $builder->where($where);
        }

        $this->applyOrder($builder, $order);

        if (! empty($group)) {
            $builder->groupBy($group);
        }

        if (! empty($limit)) {
            $builder->limit((int) $limit, $start === null ? 0 : (int) $start);
        }

        $query = $builder->get();

        return $query->getNumRows() > 0 ? $query->getResult() : null;
    }

    public function get_data_in($table, $where = [], $order = '', $group = '', $limit = null, $start = null)
    {
        return $this->get_filtered($table, $where, $order, $group, $limit, $start, 'whereIn');
    }

    public function get_data_not_in($table, $where = [], $order = '', $group = '', $limit = null, $start = null)
    {
        return $this->get_filtered($table, $where, $order, $group, $limit, $start, 'whereNotIn');
    }

    protected function get_filtered($table, $where, $order, $group, $limit, $start, string $method)
    {
        if (empty($table)) {
            $this->noTable();
        }

        $builder = $this->builder($table);

        if (! empty($where)) {
            foreach ($where as $field => $values) {
                $builder->{$method}($field, $values);
            }
        }

        $this->applyOrder($builder, $order);

        if (! empty($group)) {
            $builder->groupBy($group);
        }

        if (! empty($limit)) {
            $builder->limit((int) $limit, $start === null ? 0 : (int) $start);
        }

        $query = $builder->get();

        return $query->getNumRows() > 0 ? $query->getResult() : null;
    }

    public function add_row($table, $data = [])
    {
        if (empty($table)) {
            $this->noTable();
        }

        if (empty($data)) {
            return false;
        }

        return (bool) $this->builder($table)->insert($data);
    }

    public function add_row_multiple($table, $data = [])
    {
        if (empty($table)) {
            $this->noTable();
        }

        if (empty($data)) {
            return false;
        }

        return (bool) $this->builder($table)->insertBatch($data);
    }

    public function last_insert_id()
    {
        return $this->db->insertID();
    }

    public function edit_row($table, $data = [], $where = [])
    {
        if (empty($table)) {
            $this->noTable();
        }

        if (empty($data)) {
            return false;
        }

        $builder = $this->builder($table);

        if (! empty($where)) {
            $builder->where($where);
        }

        return (bool) $builder->update($data);
    }

    public function delete_row($table, $where = [])
    {
        if (empty($table)) {
            $this->noTable();
        }

        $builder = $this->builder($table);

        if (! empty($where)) {
            $builder->where($where);
        }

        return (bool) $builder->delete();
    }

    public function is_bof($table, $where = [])
    {
        if (empty($table)) {
            $this->noTable();
        }

        $builder = $this->builder($table);

        if (! empty($where)) {
            $builder->where($where);
        }

        return $builder->countAllResults() === 0;
    }

    public function count_data($table, $where = [])
    {
        if (empty($table)) {
            $this->noTable();
        }

        $builder = $this->builder($table);

        if (! empty($where)) {
            $builder->where($where);
        }

        return $builder->countAllResults();
    }

    public function row_count($table, $where = [])
    {
        return $this->count_data($table, $where);
    }

    public function get_row($table, $where = [], $field = '', $order = [])
    {
        if (empty($table)) {
            $this->noTable();
        }

        $builder = $this->builder($table);

        $this->applyOrder($builder, $order);

        if (! empty($where)) {
            $builder->where($where);
        }

        $row = $builder->get(1)->getRow();

        if ($row === null) {
            return '';
        }

        return $row->{$field} ?? '';
    }

    public function get_avg_row($table, $where = [], $field = '')
    {
        return $this->aggregate($table, $where, $field, 'selectAvg');
    }

    public function get_sum_row($table, $where = [], $field = '')
    {
        $value = $this->aggregate($table, $where, $field, 'selectSum');

        return $value === '' ? 0 : $value;
    }

    public function get_max_row($table, $where = [], $field = '')
    {
        return $this->aggregate($table, $where, $field, 'selectMax');
    }

    public function get_min_row($table, $where = [], $field = '')
    {
        return $this->aggregate($table, $where, $field, 'selectMin');
    }

    protected function aggregate(string $table, array $where, string $field, string $method)
    {
        if (empty($table)) {
            $this->noTable();
        }

        $builder = $this->builder($table);

        if (! empty($where)) {
            $builder->where($where);
        }

        $builder->{$method}($field, $field);
        $row = $builder->get()->getRow();

        return $row->{$field} ?? '';
    }

    public function get_query_data($sqlQuery)
    {
        $query = $this->db->query($sqlQuery);

        if ($query === false) {
            return null;
        }

        return $query->getNumRows() > 0 ? $query->getResult() : null;
    }

    public function get_query_row($sqlQuery, $field = '')
    {
        $query = $this->db->query($sqlQuery);

        if ($query === false) {
            return '';
        }

        $row = $query->getRow();

        if ($row === null) {
            return '';
        }

        return $field === '' ? $row : ($row->{$field} ?? '');
    }

    public function count_query($sqlQuery)
    {
        $query = $this->db->query($sqlQuery);

        return $query === false ? 0 : $query->getNumRows();
    }

    public function backup_db($fileType, $name, $tables = [], $addDrop = false, $addInsert = false, $forceDownload = true, $Location = '')
    {
        $backup = (new \App\Compat\LegacyDbutil())->backup([
            'tables'     => $tables,
            'format'     => $fileType,
            'add_drop'   => $addDrop,
            'add_insert' => $addInsert,
        ]);

        $nameBackup = $name . '.' . $fileType;

        if ($forceDownload) {
            $response = service('response');
            $response->setHeader('Content-Type', 'application/octet-stream');
            $response->setHeader('Content-Disposition', 'attachment; filename="' . $nameBackup . '"');
            $response->setBody($backup);
            $response->send();

            return true;
        }

        if (empty($Location)) {
            return false;
        }

        file_put_contents(rtrim($Location, '/\\') . DIRECTORY_SEPARATOR . $nameBackup, $backup);

        return true;
    }

    public function optimize_db()
    {
        (new \App\Compat\LegacyDbutil())->optimize_database();

        return true;
    }

    public function repair_table($table)
    {
        return (new \App\Compat\LegacyDbutil())->repair_table($table);
    }

    public function is_table_exists($table)
    {
        if (empty($table)) {
            $this->noTable();
        }

        return $this->db->tableExists($table);
    }

    public function get_list_table()
    {
        return $this->db->listTables();
    }

    public function get_field_table($table)
    {
        if (empty($table)) {
            $this->noTable();
        }

        return $this->db->listFields($table);
    }

    public function get_meta_table($table)
    {
        if (empty($table)) {
            $this->noTable();
        }

        return $this->db->fieldData($table);
    }

    public function create_db($dbname)
    {
        if (empty($dbname)) {
            throw new \RuntimeException('Kesalahan membuat database');
        }

        return (bool) $this->db->getForge()->createDatabase($dbname);
    }

    public function delete_database($dbname)
    {
        if (empty($dbname)) {
            $this->noTable();
        }

        return (bool) $this->db->getForge()->dropDatabase($dbname);
    }

    public function delete_table($table)
    {
        if (empty($table)) {
            $this->noTable();
        }

        return (bool) $this->db->getForge()->dropTable($table);
    }
}
