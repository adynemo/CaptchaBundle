<?php

namespace Ady\Bundle\CaptchaBundle\Captcha;

use Ady\Bundle\CaptchaBundle\Contracts\CaptchaInterface;
use Ady\Bundle\CaptchaBundle\Service\DictionaryService;
use Symfony\Contracts\Translation\TranslatorInterface;

class ConsonantCaptcha implements CaptchaInterface
{
    protected const CONSONANT = 'BCDFGHJKLMNPQRSTVWXZ';

    protected const INDEX_MAPPING = [
        '0'  => 'first',
        '1'  => 'second',
        '2'  => 'third',
        '-1' => 'last',
    ];

    /**
     * @var DictionaryService
     */
    protected $dictionary;

    /**
     * @var TranslatorInterface
     */
    protected $translator;

    public function __construct(DictionaryService $dictionary, TranslatorInterface $translator)
    {
        $this->dictionary = $dictionary;
        $this->translator = $translator;
    }

    public function getChallenge(): array
    {
        $letterIndex = array_rand(self::INDEX_MAPPING);
        $word = $this->dictionary->getRandomWord();

        return [
            $this->getQuestion($word, $letterIndex),
            $this->getAnswer($word, $letterIndex),
        ];
    }

    protected function getQuestion(string $word, int $letterIndex): string
    {
        return $this->translator->trans('captcha_sentence', [
            'index' => $this->translator->trans(sprintf('captcha_%s', self::INDEX_MAPPING[$letterIndex])),
            'letter' => $this->translator->trans('captcha_consonant'),
            'word' => $word,
        ]);
    }

    protected function getAnswer(string $word, int $letterIndex): string
    {
        if (0 > $letterIndex) {
            $letterIndex = abs($letterIndex) - 1;
            $word = strrev($word);
        }

        $answer = null;

        for ($i = $letterIndex; $i >= 0; $i--) {
            $answer = $word[strcspn($word, self::CONSONANT)];
            $word = preg_replace('/' . $answer . '/', '_', $word, 1);
        }

        return $answer;
    }

    public function checkAnswer($expected, $given): bool
    {
        return strtoupper($given) === strtoupper($expected);
    }
}
