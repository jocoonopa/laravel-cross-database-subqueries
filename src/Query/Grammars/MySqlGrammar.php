<?php

namespace Hoyvoy\CrossDatabase\Query\Grammars;

use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\Grammars\MySqlGrammar as IlluminateMySqlGrammar;

class MySqlGrammar extends IlluminateMySqlGrammar
{
    /**
     * Compile the "from" portion of the query.
     *
     * @param \Illuminate\Database\Query\Builder $query
     * @param string                             $table
     *
     * @return string
     */
    protected function compileFrom(Builder $query, $table)
    {
        // Laravel10 有可能傳過來的 table 不是 string
        // 例如當呼叫 DB::raw 的時候，過來的會是 Illuminate\Database\Query\Expression，
        // 因此加上這段判斷防止錯誤。
        //
        // @jocoonopa 2024-01-05
        if (! is_string($table)) {
            return parent::compileFrom($query, $table);
        }

        // Check for cross database query to attach database name
        if (strpos($table, '<-->') !== false) {
            list($prefix, $table, $database) = explode('<-->', $table);
            $wrappedTable = $this->wrapTable($table, true);
            $wrappedTablePrefixed = $this->wrap($prefix.$table, true);
            if ($wrappedTable != $wrappedTablePrefixed) {
                return 'from '.$this->wrap($database).'.'.$wrappedTablePrefixed.' as '.$wrappedTable;
            }

            return 'from '.$this->wrap($database).'.'.$wrappedTablePrefixed;
        }

        return 'from '.$this->wrapTable($table);
    }
}
