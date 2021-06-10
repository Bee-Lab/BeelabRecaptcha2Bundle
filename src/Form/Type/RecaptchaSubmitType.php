<?php

namespace Beelab\Recaptcha2Bundle\Form\Type;

use Beelab\Recaptcha2Bundle\Validator\Constraints\Recaptcha2;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class RecaptchaSubmitType extends AbstractType
{
    protected $siteKey;

    public function __construct(string $siteKey)
    {
        $this->siteKey = $siteKey;
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['site_key'] = $this->siteKey;
        $view->vars['button'] = $options['label'];
        $view->vars['label'] = false;
    }

    public function getBlockPrefix(): string
    {
        return 'beelab_recaptcha2_submit';
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'label' => false,
            'mapped' => false,
            'constraints' => new Recaptcha2(),
        ]);
    }

    public function getParent(): string
    {
        return TextType::class;
    }
}
