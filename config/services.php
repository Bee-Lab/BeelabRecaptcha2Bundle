<?php

use Beelab\Recaptcha2Bundle\Form\Type\RecaptchaSubmitType;
use Beelab\Recaptcha2Bundle\Form\Type\RecaptchaType;
use Beelab\Recaptcha2Bundle\Recaptcha\RecaptchaVerifier;
use Beelab\Recaptcha2Bundle\Recaptcha\SymfonyClientRequestMethod;
use Beelab\Recaptcha2Bundle\Validator\Constraints\Recaptcha2Validator;
use ReCaptcha\ReCaptcha;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Contracts\HttpClient\HttpClientInterface;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $configurator): void {
    $services = $configurator->services();

    $services
        ->set('beelab_recaptcha2.google_recaptcha', ReCaptcha::class)
        ->args([
            '%beelab_recaptcha2.secret%',
            null,   // placeholder is replaced by RequestMethodPass
        ])
    ;

    $services
        ->set(SymfonyClientRequestMethod::class)
        ->call('setClient', [service(HttpClientInterface::class)->nullOnInvalid()])
    ;

    $services
        ->set('beelab_recaptcha2.type', RecaptchaType::class)
        ->public()
        ->args(['%beelab_recaptcha2.site_key%'])
        ->tag('form.type', ['alias' => 'beelab_recaptcha2'])
    ;

    $services
        ->set('beelab_recaptcha2.submit_type', RecaptchaSubmitType::class)
        ->public()
        ->args(['%beelab_recaptcha2.site_key%'])
        ->tag('form.type', ['alias' => 'beelab_recaptcha2_submit'])
    ;

    $services
        ->set('beelab_recaptcha2.verifier', RecaptchaVerifier::class)
        ->args([
            service('beelab_recaptcha2.google_recaptcha'),
            service('request_stack'),
            '%beelab_recaptcha2.enabled%',
        ])
    ;

    $services
        ->set('beelab_recaptcha2.validator', Recaptcha2Validator::class)
        ->public()
        ->args([service('beelab_recaptcha2.verifier')])
        ->tag('validator.constraint_validator', ['alias' => 'recaptcha2'])
    ;
};
