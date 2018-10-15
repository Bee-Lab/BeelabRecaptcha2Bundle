<?php

namespace Beelab\Recaptcha2Bundle\Tests\Form\Type;

use Beelab\Recaptcha2Bundle\Form\Type\RecaptchaType;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class RecaptchaTypeTest extends TestCase
{
    public function testBuildView(): void
    {
        $form = $this->createMock('Symfony\Component\Form\FormInterface');
        $view = $this->getMockBuilder(FormView::class)->disableOriginalConstructor()->getMock();
        $type = new RecaptchaType('foo');
        $type->buildView($view, $form, []);
        $this->assertInstanceOf(RecaptchaType::class, $type);
    }

    public function testGetParent(): void
    {
        $type = new RecaptchaType('foo');
        $this->assertTrue('text' === $type->getParent() || TextType::class === $type->getParent());
    }

    public function testGetBlockPrefix(): void
    {
        $type = new RecaptchaType('foo');
        $this->assertEquals('beelab_recaptcha2', $type->getBlockPrefix());
    }

    public function testConfigureOptions(): void
    {
        $resolver = $this->createMock(OptionsResolver::class);
        $resolver->expects($this->once())->method('setDefaults');
        $type = new RecaptchaType('foo');
        $type->configureOptions($resolver);
    }
}
