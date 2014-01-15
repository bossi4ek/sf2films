<?php

namespace Sf2films\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class Sf2filmsUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
