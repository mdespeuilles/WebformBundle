<?php

namespace Mdespeuilles\WebformBundle\Form;

use AppBundle\Entity\Webform;
use AppBundle\Entity\WebformComponent;
use EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaType;
use Mdespeuilles\MarkupFieldBundle\Form\Type\MarkupType;
use Mdespeuilles\WebformBundle\Form\Type\RecaptchaSubmitType;
use Sonata\CoreBundle\Form\Type\BooleanType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class WebformType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /* @var Webform $webform */
        $webform = $options['webform'];
        
        foreach ($webform->getComponents() as $component) {
            /* @var WebformComponent $component*/
            $componentOptions = [
                'required' => $component->getRequired(),
                'mapped' => FALSE,
                'attr' => [
                    'placeholder' => $component->getPlaceholder()
                ],
                'label' => $component->getName()
            ];

            if ($component->getType() == MarkupType::class) {
                $componentOptions['label'] = false;
                $componentOptions['markup'] = $component->getName();
            }

            if ($component->isHideLabel()) {
                $componentOptions['label'] = false;
            }

            $builder->add($this::camelCase($component->getName()), $component->getType(), $componentOptions);
        }

        if ($webform->isUseCaptcha()) {
            /*$builder->add('recaptcha', EWZRecaptchaType::class, [
                "required" => true,
                "label" => false,
                "mapped" => false
            ]);*/

            $builder->add('captcha', RecaptchaSubmitType::class, [
                'label' => $webform->getSubmitString(),
            ]);
        }
        else {
            $builder->add('submit', SubmitType::class, [
                'label' => $webform->getSubmitString()
            ]);
        }
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Mdespeuilles\WebformBundle\Entity\WebformComponent',
            'webform' => null,
            "allow_extra_fields" => true
        ));
    }

    public function getBlockPrefix()
    {
        return null;
    }

    private static function camelCase($str, array $noStrip = [])
    {
        // non-alpha and non-numeric characters become spaces
        $str = preg_replace('/[^a-z0-9' . implode("", $noStrip) . ']+/i', ' ', $str);
        $str = trim($str);
        // uppercase the first character of each word
        $str = ucwords($str);
        $str = str_replace(" ", "", $str);
        $str = lcfirst($str);

        return $str;
    }
}
