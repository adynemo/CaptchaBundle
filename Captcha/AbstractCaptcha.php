<?php

namespace Ady\Bundle\CaptchaBundle\Captcha;

use Ady\Bundle\CaptchaBundle\Contracts\CaptchaInterface;
use Ady\Bundle\CaptchaBundle\Service\DictionaryService;
use RuntimeException;
use Symfony\Contracts\Translation\TranslatorInterface;

abstract class AbstractCaptcha implements CaptchaInterface
{
    protected const INDEX_MAPPING = [];

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
        $letterIndex = $this->getRandomIndex();
        $word = $this->dictionary->getRandomWord();

        return [
            $this->getQuestion($word, $letterIndex),
            $this->getAnswer($word, $letterIndex),
        ];
    }

    protected function getQuestion(string $word, int $letterIndex): string
    {
        throw new RuntimeException('You must override this method.');
    }

    protected function getAnswer(string $word, int $letterIndex): string
    {
        throw new RuntimeException('You must override this method.');
    }

    public function checkAnswer($expected, $given): bool
    {
        return strtoupper($given) === strtoupper($expected);
    }

    protected function getRandomIndex(): string
    {
        if (!is_array($this::INDEX_MAPPING) || [] === $this::INDEX_MAPPING) {
            throw new RuntimeException('INDEX_MAPPING constant must be an array and be overridden.');
        }

        return array_rand($this::INDEX_MAPPING);
    }

    protected function handleLastIndex(string $word, int $letterIndex): array
    {
        if (0 > $letterIndex) {
            $letterIndex = abs($letterIndex) - 1;
            $word = strrev($word);
        }

        return [$word, $letterIndex];
    }
}
