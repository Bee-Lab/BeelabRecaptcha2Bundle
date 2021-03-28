<?php

namespace Beelab\Recaptcha2Bundle\Tests\Form\Type;

use Beelab\Recaptcha2Bundle\Form\Type\RecaptchaType;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class RecaptchaTypeTest extends TestCase
{
    public function testBuildView(): void
    {
        /** @var FormInterface&\PHPUnit\Framework\MockObject\MockObject $form */
        $form = $this->createMock(FormInterface::class);
        /** @var FormView&\PHPUnit\Framework\MockObject\MockObject $view */
        $view = $this->createMock(FormView::class);
        $type = new RecaptchaType('foo');
        $type->buildView($view, $form, []);
        self::assertInstanceOf(RecaptchaType::class, $type);
    }

    public function testGetParent(): void
    {
        $type = new RecaptchaType('foo');
        self::assertTrue('text' === $type->getParent() || TextType::class === $type->getParent());
    }

    public function testGetBlockPrefix(): void
    {
        $type = new RecaptchaType('foo');
        self::assertEquals('beelab_recaptcha2', $type->getBlockPrefix());
    }

    public function testConfigureOptions(): void
    {
        /** @var OptionsResolver&\PHPUnit\Framework\MockObject\MockObject $resolver */
        $resolver = $this->createMock(OptionsResolver::class);
        $resolver->expects(self::once())->method('setDefaults');
        $type = new RecaptchaType('foo');
        $type->configureOptions($resolver);
    }
}
