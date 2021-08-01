<?php

namespace Ady\Bundle\CaptchaBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CaptchaBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
