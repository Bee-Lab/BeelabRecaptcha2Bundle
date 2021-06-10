BeelabRecaptcha2Bundle
======================

1. [Installation](#1-installation)
2. [Configuration](#2-configuration)
3. [Usage](#3-usage)
4. [Customization](#4-customization)

### 1. Installation

Run from terminal:

```bash
$ composer require beelab/recaptcha2-bundle
```

If you don't use Flex, you need to manually enable bundle in your kernel:

```php
<?php
// app/AppKernel.php
public function registerBundles(): array
{
    $bundles = [
        // ...
        new Beelab\Recaptcha2Bundle\BeelabRecaptcha2Bundle(),
    ];
}
```

### 2. Configuration

Add following lines in your configuration:

```yaml
# config/packages/beelab_recaptcha2.yaml

beelab_recaptcha2:
    site_key: '%env(APP_RECAPTCHA_SITE_KEY)%'
    secret: '%env(APP_RECAPTCHA_SECRET)%'
```

You should define `APP_RECAPTCHA_SITE_KEY` and `APP_RECAPTCHA_SECRET` in your environment variabiles.

If you're still using the old, non-environment system:

```yaml
# app/config/config.yml

beelab_recaptcha2:
    site_key: '%recaptcha_site_key%'
    secret: '%recaptcha_secret%'
```

And define `recaptcha_site_key` and `recaptcha_secret` parameters in `app/config/parameters.yml` file.

Since you cannot use a CAPTCHA in a test, you also should add following lines in your test configuration:

```yaml
# config/packages/test/beelab_recaptcha2.yaml (or app/config/config_test.yml)

beelab_recaptcha2:
    enabled: false
```

If your PHP environment has restrictions about `file_get_contents()` making HTTP requests,
you can use another `RequestMethod` from Google's Recaptcha library.

Currently, this bundle supports the default `Post` and `CurlPost` methods.
You can use the latter by adding in your `config.yml`:

```yaml
# config/packages/beelab_recaptcha2.yaml (or app/config/config.yml)

beelab_recaptcha2:
    request_method: curl_post
```

Otherwise, the default value `post` will be used.

### 3. Usage

In your form, use `Beelab\Recaptcha2Bundle\Form\Type\RecaptchaType` form type, as any other Symfony form types.
Example:

```php
<?php
// src/Form/RegistrationType.php
namespace App\Form;

use Beelab\Recaptcha2Bundle\Form\Type\RecaptchaType;
use Beelab\Recaptcha2Bundle\Validator\Constraints\Recaptcha2;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('name')
            ->add('plainPassword', PasswordType::class)
            ->add('captcha', RecaptchaType::class, [
                // You can use RecaptchaSubmitType
                // "groups" option is not mandatory
                'constraints' => new Recaptcha2(['groups' => ['create']]),
            ])
            // For Invisible Recaptcha
            /*
            ->add('captcha', RecaptchaSubmitType::class, [
                'label' => 'Save'
            ])
            */
        ;
    }
}
```

As you can see, you can pass an array of validation groups to `Recaptcha2` constraint.
For example, if you use it with registration in FOSUserBundle, you should use the
"Registration" group. If you don't use groups, you should remove such option.

In your template (likely in your main layout file), include a line like the following:

``` html
<script src="//www.google.com/recaptcha/api.js?hl=en"></script>
```

The `hl` parameter can be used to customize language.
For example, you can use the following in a Twig template, to get the currently used language:


```jinja
<script src="//www.google.com/recaptcha/api.js?hl={{ app.request.locale }}"></script>
```

To use invisible ReCaptcha you will need to define an additional callback:

```js
function recaptchaCallback (token) {
    var elem = document.querySelector(".g-recaptcha");
    while ((elem = elem.parentElement) !== null) {
    if (elem.nodeType === Node.ELEMENT_NODE && elem.tagName === 'FORM') {
        elem.submit();
        break;
    }
}
```

### 4. Customization

If you want to customize the render of Recaptcha widget, just override `beelab_recaptcha2_widget`
widget in one of your form themes.
For example, suppose you want to display the compact version of the widget, and suppose that
you configured a `_form_theme.html.twig` file under `form_themes` option of `twig` configuration.
You can add to `_form_theme.html.twig` file the following lines:

```html+jinja
{% block beelab_recaptcha2_widget -%}
    <div class="g-recaptcha" data-sitekey="{{ site_key }}" data-size="compact"></div>
{%- endblock %}
```

