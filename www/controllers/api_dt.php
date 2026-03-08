<?php

declare(strict_types=1);

namespace Adhoc\Controller;

/**
 * Points de terminaison d'api pour dataTables
 */
final class Controller
{
    /**
     * @return array<mixed>
     */
    public static function membres(): array
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        }

        return [];
    }
}
