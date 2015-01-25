<?php

namespace Minsal\sifdaBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MinsalsifdaBundle extends Bundle
{
     public function getParent()
    {
    return 'FOSUserBundle';
    }
}
