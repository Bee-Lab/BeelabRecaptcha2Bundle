<?php

namespace Beelab\Recaptcha2Bundle\Tests\Form\Type;

use Beelab\Recaptcha2Bundle\Form\Type\RecaptchaSubmitType;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class RecaptchaSubmitTypeTest extends TestCase
{
    public function testBuildView(): void
    {
        $form = $this->createMock(FormInterface::class);
        $view = $this->getMockBuilder(FormView::class)->disableOriginalConstructor()->getMock();
        $type = new RecaptchaSubmitType('foo');
        $type->buildView($view, $form, ['label' => false]);
        self::assertInstanceOf(RecaptchaSubmitType::class, $type);
    }

    public function testGetParent(): void
    {
        $type = new RecaptchaSubmitType('foo');
        self::assertEquals(TextType::class, $type->getParent());
    }

    public function testGetBlockPrefix(): void
    {
        $type = new RecaptchaSubmitType('foo');
        self::assertEquals('beelab_recaptcha2_submit', $type->getBlockPrefix());
    }

    public function testConfigureOptions(): void
    {
        $resolver = $this->createMock(OptionsResolver::class);
        $resolver->expects(self::once())->method('setDefaults');
        $type = new RecaptchaSubmitType('foo');
        $type->configureOptions($resolver);
    }
}
