<?php

namespace Ady\Bundle\CaptchaBundle\Contracts;

interface CaptchaInterface
{
    public function getChallenge(): array;

    public function checkAnswer($expected, $given): bool;
}
