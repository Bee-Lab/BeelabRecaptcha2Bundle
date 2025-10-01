<?php
// config/services.php

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $configurator): void {
    $services = $configurator->services();

    // sensible defaults
    $services->defaults()
        ->autowire()
        ->autoconfigure()
        ->private();

    // The service that the compiler pass will inspect and modify.
    // RequestMethodPass expects this service id and will replace argument index 1.
    $services->set('beelab_recaptcha2.google_recaptcha', \Beelab\Recaptcha2Bundle\Recaptcha\RecaptchaVerifier::class)
        ->args([
            '%beelab_recaptcha2.secret%', // constructor arg 0 (the secret)
            null,                         // constructor arg 1 (placeholder: replaced by RequestMethodPass)
        ]);

    // Validator service must match the string returned by Recaptcha2::validatedBy()
    // Recaptcha2::validatedBy() returns 'recaptcha2' so we register the service id 'recaptcha2'.
    $services->set('recaptcha2', \Beelab\Recaptcha2Bundle\Validator\Constraints\Recaptcha2Validator::class)
        ->args([service('beelab_recaptcha2.google_recaptcha')])
        ->tag('validator.constraint_validator');

    // Form type
    $services->set(\Beelab\Recaptcha2Bundle\Form\Type\RecaptchaType::class)
        ->tag('form.type');
};
