<?php

namespace Mdespeuilles\WebformBundle\Form\Type;

use Mdespeuilles\WebformBundle\Constraints\Recaptcha;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use \Symfony\Component\OptionsResolver\OptionsResolver;

class RecaptchaSubmitType extends \Symfony\Component\Form\AbstractType
{

    private $key;

    public function __construct($key)
    {
        $this->key = $key;
    }

    public function  configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'mapped' => false,
            'constraints' => new Recaptcha()
        ]);
    }

    public function getBlockPrefix()
    {
        return 'recaptcha_submit';
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['label'] = false;
        $view->vars['key'] = $this->key;
        $view->vars['button'] = $options['label'];
    }

    public function getParent()
    {
        return TextType::class;
    }
}
