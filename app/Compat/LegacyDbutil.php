<?php

namespace App\Compat;

/**
 * CI3 database utility shim (backup/optimize/repair).
 */
class LegacyDbutil
{
    public function backup(array $params = [])
    {
        $format = $params['format'] ?? 'txt';
        $tables = $params['tables'] ?? [];
        $db     = Registry::db();

        $list = $tables !== [] ? $tables : $db->listTables();
        $dump = "-- CodeIgniter SQL Dump\n-- Generated: " . date('Y-m-d H:i:s') . "\n\n";

        foreach ($list as $table) {
            $create = $db->query('SHOW CREATE TABLE `' . $table . '`')->getRowArray();
            $ddl    = $create['Create Table'] ?? ($create['Create View'] ?? '');

            if ($ddl !== '') {
                $dump .= 'DROP TABLE IF EXISTS `' . $table . "`;\n" . $ddl . ";\n\n";
            }

            if (($params['add_insert'] ?? false) !== false) {
                $rows = $db->query('SELECT * FROM `' . $table . '`')->getResultArray();
                foreach ($rows as $row) {
                    $values = array_map(static fn ($value) => $value === null ? 'NULL' : $db->escape($value), $row);
                    $dump .= 'INSERT INTO `' . $table . '` (' . implode(', ', array_map(static fn ($key) => '`' . $key . '`', array_keys($row))) . ') VALUES (' . implode(', ', $values) . ");\n";
                }
                $dump .= "\n";
            }
        }

        if (strtolower($format) === 'gzip') {
            return gzencode($dump);
        }

        return $dump;
    }

    public function optimize_database()
    {
        $db = Registry::db();
        foreach ($db->listTables() as $table) {
            $db->query('OPTIMIZE TABLE `' . $table . '`');
        }

        return true;
    }

    public function optimize_table(string $table)
    {
        Registry::db()->query('OPTIMIZE TABLE `' . $table . '`');

        return true;
    }

    public function repair_table(string $table)
    {
        $result = Registry::db()->query('REPAIR TABLE `' . $table . '`');

        return $result !== false;
    }
}
