<?php

namespace App\Helpers;


class Layout
{
    public function __invoke()
    {
        $route = request()->route();
        if ($route && str_starts_with($route->getName(), 'seller.')) {
            return 'layouts.provider';
        }

        return 'layouts.main';
    }
}
