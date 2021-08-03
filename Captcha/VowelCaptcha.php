<?php

namespace Ady\Bundle\CaptchaBundle\Captcha;

use Ady\Bundle\CaptchaBundle\Contracts\CaptchaInterface;

class VowelCaptcha extends AbstractCaptcha implements CaptchaInterface
{
    protected const VOWEL = 'AEIOUY';

    protected const INDEX_MAPPING = [
        '0' => 'first',
        '1' => 'second',
        '2' => 'third',
        '-1' => 'last',
    ];

    protected function getQuestion(string $word, int $letterIndex): string
    {
        return $this->translator->trans('captcha_sentence', [
            '%index%' => $this->translator->trans(sprintf('captcha_%s', self::INDEX_MAPPING[$letterIndex])),
            '%letter%' => $this->translator->trans('captcha_vowel'),
            '%word%' => $word,
        ]);
    }

    protected function getAnswer(string $word, int $letterIndex): string
    {
        [$word, $letterIndex] = $this->handleLastIndex($word, $letterIndex);

        $answer = null;

        for ($i = $letterIndex; $i >= 0; --$i) {
            $answer = $word[strcspn($word, self::VOWEL)];
            $word = preg_replace('/'.$answer.'/', '_', $word, 1);
        }

        return $answer;
    }
}
