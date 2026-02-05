<?php

namespace App\Support\SchemaSnapshot;

use Illuminate\Support\Facades\DB;

class DatabaseIntrospector
{
    public function tables(): array
    {
        return collect(DB::select("
            SELECT TABLE_NAME
            FROM information_schema.tables
            WHERE table_schema = DATABASE()
        "))->pluck('TABLE_NAME')->all();
    }

    public function columns(string $table): array
    {
        return DB::select("
            SELECT
                COLUMN_NAME                    AS name,
                COLUMN_TYPE                    AS type,
                IS_NULLABLE                    AS nullable,
                COLUMN_DEFAULT                 AS default_value,
                EXTRA                          AS extra,
                CHARACTER_MAXIMUM_LENGTH       AS length
            FROM information_schema.columns
            WHERE table_schema = DATABASE()
              AND table_name = ?
            ORDER BY ORDINAL_POSITION
        ", [$table]);
    }

    public function indexes(string $table): array
    {
        return DB::select("
            SELECT
                INDEX_NAME   AS name,
                COLUMN_NAME  AS column_name,
                NON_UNIQUE   AS non_unique
            FROM information_schema.statistics
            WHERE table_schema = DATABASE()
              AND table_name = ?
        ", [$table]);
    }

    public function foreignKeys(string $table): array
    {
        return DB::select("
            SELECT
                kcu.CONSTRAINT_NAME        AS name,
                kcu.COLUMN_NAME            AS column_name,
                kcu.REFERENCED_TABLE_NAME  AS referenced_table,
                kcu.REFERENCED_COLUMN_NAME AS referenced_column,
                rc.UPDATE_RULE             AS on_update,
                rc.DELETE_RULE             AS on_delete
            FROM information_schema.KEY_COLUMN_USAGE kcu
            JOIN information_schema.REFERENTIAL_CONSTRAINTS rc
              ON rc.CONSTRAINT_NAME = kcu.CONSTRAINT_NAME
             AND rc.CONSTRAINT_SCHEMA = kcu.CONSTRAINT_SCHEMA
            WHERE kcu.TABLE_SCHEMA = DATABASE()
              AND kcu.TABLE_NAME = ?
              AND kcu.REFERENCED_TABLE_NAME IS NOT NULL
        ", [$table]);
    }
}
