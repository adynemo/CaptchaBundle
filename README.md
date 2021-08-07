<div align="center">
<h2>CaptchaBundle</h2>

[![pipeline status](https://gitlab.com/adynemo/captchabundle/badges/main/pipeline.svg)](https://gitlab.com/adynemo/captchabundle/-/commits/main)
[![coverage report](https://gitlab.com/adynemo/captchabundle/badges/main/coverage.svg)](https://gitlab.com/adynemo/captchabundle/-/commits/main)

</div>

# Overview

This bundle allows you to add a simple and privacy-friendly captcha to your website's forms.

No Google dependency or other third party. This is just a simple challenge, a random question that the user have to answer to validate the form.

---------------------

# Requirements

| Support | Version     |
| ------- | ------------|
| Symfony | ^4.0 / ^5.0 |
| PHP     | ^7.2 / ^8.0 |

# Installation

```shell
composer require ady/captcha-bundle --prefer-dist
```

# Use

### Add field

Add a new field to your form with `CaptchaType`. Some options are recommended:

- `mapped` should set to `false` if your form is mapped to an entity
- `required` should set to `true`

So, your captcha field looks like:

```php
use Ady\Bundle\CaptchaBundle\Form\CaptchaType;

->add('captcha', CaptchaType::class, [
    'mapped' => false,
    'required' => true,
])
```

### Available challenges

- Consonant

Question: `What is the third consonant of the word BARBITURIQUE?`

Answer: `B`

- Letter

Question: `What is the fifth letter of the word ESCARPOLETTE?`

Answer: `R`

- Vowel

Question: `What is the first vowel of the word JACTANCE?`

Answer: `A`

### Mechanism

The question is design like `What is the %index% %letter% of the word %word%?`. The challenge is chosen randomly among available challenges. The chosen challenge defines the `%letter%` and set at random the `%index%`. Then, the `%word%` is also pick off randomly from batch of words (see [Dictionary](Service/DictionaryService.php)).

## New captcha

You can create your own captcha. It should extend [AbstractCaptcha](Captcha/AbstractCaptcha.php) and it must implement [CaptchaInterface](Contracts/CaptchaInterface.php), that's it!

---------------------

Contributing
============

You can propose new captcha or any improvement. To do that, thanks to fork this repository and to submit one merge request. Add some unit test is appreciated. Be sure to run `composer test` before submitting your code.

Also, if you have any issue, please submit it on:
- [GitLab](https://gitlab.com/adynemo/captchabundle/-/issues/new)
- [GitHub](https://github.com/adynemo/CaptchaBundle/issues/new)
