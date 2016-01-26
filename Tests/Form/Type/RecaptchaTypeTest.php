<?php

namespace Beelab\Recaptcha2Bundle\Tests\Form\Type;

use Beelab\Recaptcha2Bundle\Form\Type\RecaptchaType;

class RecaptchaTypeTest extends \PHPUnit_Framework_TestCase
{
    public function testBuildView()
    {
        $form = $this->getMock('Symfony\Component\Form\FormInterface');
        $view = $this->getMockBuilder('Symfony\Component\Form\FormView')->disableOriginalConstructor()->getMock();
        $type = new RecaptchaType('foo');
        $type->buildView($view, $form, array());
    }

    public function testGetParent()
    {
        $type = new RecaptchaType('foo');
        $this->assertTrue('form' === $type->getParent() || 'Symfony\Component\Form\Extension\Core\Type\FormType' === $type->getParent());
    }

    public function testGetName()
    {
        $type = new RecaptchaType('foo');
        $this->assertEquals('beelab_recaptcha2', $type->getName());
    }
}
