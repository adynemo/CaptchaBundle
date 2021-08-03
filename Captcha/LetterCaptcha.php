<?php

namespace Ady\Bundle\CaptchaBundle\Captcha;

use Ady\Bundle\CaptchaBundle\Contracts\CaptchaInterface;

class LetterCaptcha extends AbstractCaptcha implements CaptchaInterface
{
    protected const INDEX_MAPPING = [
        '0' => 'first',
        '1' => 'second',
        '2' => 'third',
        '3' => 'fourth',
        '4' => 'fifth',
        '-1' => 'last',
    ];

    protected function getQuestion(string $word, int $letterIndex): string
    {
        return $this->translator->trans('captcha_sentence', [
            '%index%' => $this->translator->trans(sprintf('captcha_%s', self::INDEX_MAPPING[$letterIndex])),
            '%letter%' => $this->translator->trans('captcha_letter'),
            '%word%' => $word,
        ]);
    }

    protected function getAnswer(string $word, int $letterIndex): string
    {
        [$word, $letterIndex] = $this->handleLastIndex($word, $letterIndex);

        return $word[$letterIndex];
    }
}
