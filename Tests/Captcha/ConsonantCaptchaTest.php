<?php

namespace Ady\Bundle\CaptchaBundle\Tests\Captcha;

use Ady\Bundle\CaptchaBundle\Captcha\ConsonantCaptcha;
use Ady\Bundle\CaptchaBundle\Service\DictionaryService;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\Translation\TranslatorInterface;

class ConsonantCaptchaTest extends TestCase
{
    public function testCanReturnOneChallenge()
    {
        $index = 'index';
        $letter = 'letter';
        $word = 'WORD';
        $question = 'question';

        $dictionary = $this->getMockBuilder(DictionaryService::class)
            ->onlyMethods(['getRandomWord'])
            ->getMock();
        $dictionary
            ->method('getRandomWord')
            ->willReturn($word);

        $translatorFirstCallArgs = ['captcha_second'];
        $translatorSecondCallArgs = ['captcha_consonant'];
        $translatorThirdCallArgs = ['captcha_sentence', [
            '%index%' => $index,
            '%letter%' => $letter,
            '%word%' => $word,
        ]];

        $translator = $this->createMock(TranslatorInterface::class);

        $translator
            ->expects($this->exactly(3))
            ->method('trans')
            ->withConsecutive($translatorFirstCallArgs, $translatorSecondCallArgs, $translatorThirdCallArgs)
            ->willReturnOnConsecutiveCalls($index, $letter, $question);

        $captcha = $this->getMockBuilder(ConsonantCaptcha::class)
            ->setConstructorArgs([$dictionary, $translator])
            ->onlyMethods(['getRandomIndex'])
            ->getMock();
        $captcha
            ->method('getRandomIndex')
            ->willReturn('1');

        $challenge = $captcha->getChallenge();

        $this->assertIsArray($challenge);
        $this->assertEquals([$question, 'R'], $challenge);
    }

    public function testCanReturnLastConsonantChallenge()
    {
        $index = 'index';
        $letter = 'letter';
        $word = 'WORD';
        $question = 'question';

        $dictionary = $this->getMockBuilder(DictionaryService::class)
            ->onlyMethods(['getRandomWord'])
            ->getMock();
        $dictionary
            ->method('getRandomWord')
            ->willReturn($word);

        $translatorFirstCallArgs = ['captcha_last'];
        $translatorSecondCallArgs = ['captcha_consonant'];
        $translatorThirdCallArgs = ['captcha_sentence', [
            '%index%' => $index,
            '%letter%' => $letter,
            '%word%' => $word,
        ]];

        $translator = $this->createMock(TranslatorInterface::class);

        $translator
            ->expects($this->exactly(3))
            ->method('trans')
            ->withConsecutive($translatorFirstCallArgs, $translatorSecondCallArgs, $translatorThirdCallArgs)
            ->willReturnOnConsecutiveCalls($index, $letter, $question);

        $captcha = $this->getMockBuilder(ConsonantCaptcha::class)
            ->setConstructorArgs([$dictionary, $translator])
            ->onlyMethods(['getRandomIndex'])
            ->getMock();
        $captcha
            ->method('getRandomIndex')
            ->willReturn('-1');

        $challenge = $captcha->getChallenge();

        $this->assertIsArray($challenge);
        $this->assertEquals([$question, 'D'], $challenge);
    }

    public function testCanAcceptAnswer()
    {
        $dictionary = new DictionaryService();
        $translator = $this->createMock(TranslatorInterface::class);

        $captcha = new ConsonantCaptcha($dictionary, $translator);

        $check = $captcha->checkAnswer('A', 'a');

        $this->assertTrue($check);
    }

    public function testCanRefuseAnswer()
    {
        $dictionary = new DictionaryService();
        $translator = $this->createMock(TranslatorInterface::class);

        $captcha = new ConsonantCaptcha($dictionary, $translator);

        $check = $captcha->checkAnswer('A', 'b');

        $this->assertFalse($check);
    }
}
