<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class PageController
{
    public function number()
    {
        $number = random_int(0, 10);

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }
}