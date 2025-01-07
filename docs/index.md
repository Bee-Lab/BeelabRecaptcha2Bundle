# BeelabRecaptcha2Bundle

## 1. Installation

Run from the terminal:

```bash
composer require beelab/recaptcha2-bundle
```

Flex automatically enables the bundle.

If Flex asks you to execute the recipe from `google\recaptcha`, answer "no". If you mistakenly answer "yes" instead,
remove the service configuration created by that recipe, since it would be a duplication of the service defined
by this bundle.

## 2. Configuration

Add the following lines to your configuration:

```yaml
# config/packages/beelab_recaptcha2.yaml

beelab_recaptcha2:
    site_key: '%env(APP_RECAPTCHA_SITE_KEY)%'
    secret: '%env(APP_RECAPTCHA_SECRET)%'
```

You should define `APP_RECAPTCHA_SITE_KEY` and `APP_RECAPTCHA_SECRET` in your environment variables.

Since you cannot use a CAPTCHA in a test, you also should add the following lines in your test configuration:

```yaml
# config/packages/test/beelab_recaptcha2.yaml

beelab_recaptcha2:
    enabled: false
```

If your PHP environment has restrictions about `file_get_contents()` making HTTP requests,
you can use another `RequestMethod` from Google's Recaptcha library.

Currently, this bundle supports the default `Post` and `CurlPost` methods.
You can use the latter by adding in your `config.yml`:

```yaml
# config/packages/beelab_recaptcha2.yaml

beelab_recaptcha2:
    request_method: curl_post
```

Otherwise, the default value `post` will be used.

## 3. Usage

In your form, use `Beelab\Recaptcha2Bundle\Form\Type\RecaptchaType` form type, as any other Symfony form type.
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
"Registration" group. If you don't use groups, you should remove such an option.

In your template (likely in your main layout file), include a line like the following:

```html
<script src="//www.google.com/recaptcha/api.js?hl=en"></script>
```

The `hl` parameter can be used to customize language.
For example, you can use the following in a Twig template, to get the currently used language:


```jinja
<script src="//www.google.com/recaptcha/api.js?hl={{ app.request.locale }}"></script>
```

## 4. Customization

If you want to customize the rendering of Recaptcha widget, just override `beelab_recaptcha2_widget`
widget in one of your form themes.
For example, suppose you want to display the compact version of the widget and suppose that
you configured a `_form_theme.html.twig` file under `form_themes` option of `twig` configuration.
You can add to your `_form_theme.html.twig` file the following lines:

```html+jinja
{% block beelab_recaptcha2_widget -%}
    <div class="g-recaptcha" data-sitekey="{{ site_key }}" data-size="compact"></div>
{%- endblock %}
```

