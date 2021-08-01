<?php

namespace Ady\CaptchaBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AdyCaptchaBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
