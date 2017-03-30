<?php

namespace Beelab\Recaptcha2Bundle\Tests\Form\Type;

use Beelab\Recaptcha2Bundle\Form\Type\RecaptchaType;
use PHPUnit\Framework\TestCase;

class RecaptchaTypeTest extends TestCase
{
    public function testBuildView()
    {
        $form = $this->createMock('Symfony\Component\Form\FormInterface');
        $view = $this->getMockBuilder('Symfony\Component\Form\FormView')->disableOriginalConstructor()->getMock();
        $type = new RecaptchaType('foo');
        $type->buildView($view, $form, []);
        $this->assertInstanceOf(RecaptchaType::class, $type);
    }

    public function testGetParent()
    {
        $type = new RecaptchaType('foo');
        $this->assertTrue('text' === $type->getParent() || 'Symfony\Component\Form\Extension\Core\Type\TextType' === $type->getParent());
    }

    public function testGetBlockPrefix()
    {
        $type = new RecaptchaType('foo');
        $this->assertEquals('beelab_recaptcha2', $type->getBlockPrefix());
    }

    public function testConfigureOptions()
    {
        $resolver = $this->createMock('Symfony\Component\OptionsResolver\OptionsResolver');
        $resolver->expects($this->once())->method('setDefaults');
        $type = new RecaptchaType('foo');
        $type->configureOptions($resolver);
    }
}
