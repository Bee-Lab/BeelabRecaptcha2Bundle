BeelabRecaptcha2Bundle
======================

1. [Installation](#1-installation)
2. [Configuration](#2-configuration)
3. [Usage](#3-usage)

### 1. Installation

Run from terminal:

```bash
$ php composer.phar require beelab/recaptcha2-bundle
```
> **Note**: if you use Symfony 2.3, you must use ``0.1`` branch, so replace previous command with
> ``php composer.phar require beelab/recaptcha2-bundle:0.1.*``


Enable bundle in the kernel:

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Beelab\Recaptcha2Bundle\BeelabRecaptcha2Bundle(),
    );
}
```

### 2. Configuration

Add following lines in your configuration:

``` yaml
# app/config/config.yml

beelab_recaptcha2:
    site_key: %recaptcha_site_key%
    secret: %recaptcha_secret%
```

You should define ``recaptcha_site_key`` and ``recaptcha_secret`` parameters in your ``app/config/parameters.yml`` file.

Since you cannot use a CAPTCHA in a test, you also should add following lines in your test configuration:

``` yaml
# app/config/config_test.yml

beelab_recaptcha2:
    enabled: false
```

### 3. Usage

In your form, use ``beelab_recaptcha2`` form type, as any other Symfony form types.
Example:

``` php
<?php
// src/AppBundle/Form/Type/RegistrationType

namespace AppBundle\Form\Type;

use Beelab\Recaptcha2Bundle\Validator\Constraints\Recaptcha2;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('name')
            ->add('plainPassword', 'password')
            ->add('captcha', 'beelab_recaptcha2', array(
                'label' => false,
                'mapped' => false,
                'constraints' => new Recaptcha2(array('groups' => array('create'))),
            ))
        ;
    }
}

```

As you can see, you can pass an array of validation groups to ``Recaptcha2`` constraint.

In your template (likely in your main layout file), include a line like the following:

``` html
<script src="//www.google.com/recaptcha/api.js?hl=en"></script>
```

The ``hl`` parameter let you customize the language.
