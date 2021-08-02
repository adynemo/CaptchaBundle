<?php

namespace Ady\Bundle\CaptchaBundle\Form;

use Ady\Bundle\CaptchaBundle\Contracts\CaptchaInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class CaptchaType extends AbstractType
{
    public const SESSION_KEY = 'captcha_answer';

    /**
     * @var CaptchaInterface
     */
    protected $captcha;

    /**
     * @var SessionInterface
     */
    protected $session;

    /**
     * @var string
     */
    protected $question;

    /**
     * @var string
     */
    protected $previousAnswer;

    /**
     * @var string
     */
    protected $nextAnswer;

    public function __construct(SessionInterface $session, iterable $captchas)
    {
        $captchas = iterator_to_array($captchas);
        $this->captcha = $captchas[array_rand($captchas)];
        $this->session = $session;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        list($this->question, $this->nextAnswer) = $this->captcha->getChallenge();
        $this->handleSession();
    }

    protected function handleSession()
    {
        $this->previousAnswer = $this->session->get(self::SESSION_KEY, null);
        $this->session->set(self::SESSION_KEY, $this->nextAnswer);
    }

    public function validateCaptcha($data, ExecutionContextInterface $context)
    {
        if (false === $this->captcha->checkAnswer($data, $this->previousAnswer)) {
            $context
                ->buildViolation('captcha_invalid')
                ->setTranslationDomain('messages')
                ->addViolation();
        }
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['captcha_question'] = $this->question;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'attr' => [
                'autocapitalize' => 'none',
                'autocorrect' => 'off',
                'spellcheck' => 'false',
            ],
            'constraints' => [
                new Callback([
                    'callback' => [$this, 'validateCaptcha'],
                ]),
            ],
            'mapped' => false,
            'required' => false,
        ]);
    }

    public function getParent()
    {
        return TextType::class;
    }
}
