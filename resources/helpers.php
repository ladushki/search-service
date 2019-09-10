<?php

use Illuminate\Support\Debug\Dumper;
use Illuminate\Support\Facades\DB;

if (!function_exists('dd_query')) {
    $_global_query_count = 0;
    /**
     * Dump the next database query.
     * Quick fix for not rendering dd_query() in browser's network tab.
     *
     * @param int $count
     *
     * @return void
     */
    function dd_query($count = 1)
    {
        DB::listen(function ($query) use ($count) {
            global $_global_query_count;
            while (strpos($query->sql, '?')) {
                $query->sql = preg_replace('/\?/', '"' . array_shift($query->bindings) . '"', $query->sql, 1);
            }
            if (++$_global_query_count === $count) {
                dd($query->sql);
            } else {
                d($query->sql);
            }
        });
    }
}
if (! function_exists('dp')) {
    /**
     * Dump the passed variables and end the script.
     *
     * @param  mixed
     * @return void
     */
    function dp(...$args)
    {
        foreach ($args as $x) {
            (new Dumper)->dump($x);
        }
    }
}
