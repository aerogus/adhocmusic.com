<?php

declare(strict_types=1);

namespace Adhoc\Utils;

class Debug
{
    /**
     * @param mixed $var
     *
     * @return void
     */
    public static function dump(mixed $var): void
    {
        echo '<div class="infobulle info alert alert-info">';
        echo "<pre>" . print_r($var, true) . "</pre>";
        echo '</div>';
    }
}
