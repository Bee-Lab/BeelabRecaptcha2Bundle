<?php

namespace Beelab\Recaptcha2Bundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

/**
 * Type for ReCaptcha.
 */
class RecaptchaType extends AbstractType
{
    protected $siteKey;

    public function __construct($siteKey)
    {
        $this->siteKey = $siteKey;
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['site_key'] = $this->siteKey;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'form';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'beelab_recaptcha2';
    }
}
