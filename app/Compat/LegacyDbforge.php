<?php

namespace App\Compat;

/**
 * CI3 database forge shim.
 */
class LegacyDbforge
{
    protected function forge()
    {
        return Registry::db()->getForge();
    }

    public function create_database(string $name): bool
    {
        return (bool) $this->forge()->createDatabase($name);
    }

    public function drop_database(string $name): bool
    {
        return (bool) $this->forge()->dropDatabase($name);
    }

    public function drop_table(string $table): bool
    {
        return (bool) $this->forge()->dropTable($table);
    }

    public function create_table(string $table, array $fields = [], bool $if_not_exists = false): bool
    {
        return (bool) $this->forge()->addField($fields)->createTable($table, true, $if_not_exists);
    }

    public function add_column(string $table, string $field, array $definition = []): bool
    {
        return (bool) $this->forge()->addColumn($table, $field, $definition);
    }

    public function drop_column(string $table, string $field): bool
    {
        return (bool) $this->forge()->dropColumn($table, $field);
    }

    public function table_exists(string $table): bool
    {
        return Registry::db()->tableExists($table);
    }
}
