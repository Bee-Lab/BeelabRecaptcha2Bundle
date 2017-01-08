BeelabRecaptcha2Bundle
======================

1. [Installation](#1-installation)
2. [Configuration](#2-configuration)
3. [Usage](#3-usage)

### 1. Installation

Run from terminal:

```bash
$ composer require beelab/recaptcha2-bundle
```

Enable bundle in the kernel:

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = [
        // ...
        new Beelab\Recaptcha2Bundle\BeelabRecaptcha2Bundle(),
    ];
}
```

### 2. Configuration

Add following lines in your configuration:

``` yaml
# app/config/config.yml

beelab_recaptcha2:
    site_key: "%recaptcha_site_key%"
    secret: "%recaptcha_secret%"
```

You should define `recaptcha_site_key` and `recaptcha_secret` parameters in your `app/config/parameters.yml` file.

Since you cannot use a CAPTCHA in a test, you also should add following lines in your test configuration:

``` yaml
# app/config/config_test.yml

beelab_recaptcha2:
    enabled: false
```

If your PHP environment has restrictions about `file_get_contents()` making HTTP requests,
you can use another `RequestMethod` from Google's Recaptcha library.

Currently, this bundle supports the default `Post` and `CurlPost` methods.
You can use the latter by adding in your `config.yml`:

``` yaml
# app/config/config.yml

beelab_recaptcha2:
    request_method: curl_post
```

Otherwise, the default value `post` will be used.

### 3. Usage

In your form, use `Beelab\Recaptcha2Bundle\Form\Type\RecaptchaType` form type, as any other Symfony form types.
Example:

``` php
<?php
// src/AppBundle/Form/Type/RegistrationType
namespace AppBundle\Form\Type;

use Beelab\Recaptcha2Bundle\Form\Type\RecaptchaType;
use Beelab\Recaptcha2Bundle\Validator\Constraints\Recaptcha2;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('name')
            ->add('plainPassword', PasswordType::class)
            ->add('captcha', RecaptchaType::class, [
                'label' => false,
                'mapped' => false,
                'constraints' => new Recaptcha2(['groups' => ['create']]),
            ])
        ;
    }
}

```

As you can see, you can pass an array of validation groups to `Recaptcha2` constraint.

In your template (likely in your main layout file), include a line like the following:

``` html
<script src="//www.google.com/recaptcha/api.js?hl=en"></script>
```

The `hl` parameter can be used to customize language.
