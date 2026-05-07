<?php

namespace App\Core;

/**
 * Třída obsashující statické metody, které nesouvísí s tématem ale pomáhají s některými repetetivními akcemi.
 */
class Helpers {
    /**
     * Spojí prvky do cesty tak, aby byly korektní s daným OS
     * @param string ...$segments prvky které budou spojeny do cesty tak, aby to vyhovovalo OS
     * @return string Cestu která odpovídá OS
     */
    public static function path_join(string ...$segments): string
    {
        // Spojíme všechny platné segmenty oddělovačem
        $path = implode(DIRECTORY_SEPARATOR, array_filter($segments, function($segment) {
            return $segment !== '' && $segment !== null;
        }));

        // Nahradíme vícenásobná lomítka (např. // nebo \\) jedním platným oddělovačem pro daný OS
        return preg_replace('#[\\\\/]+#', DIRECTORY_SEPARATOR, $path);
    }
}