<?php
/**
 * Created by PhpStorm.
 * User: maxence
 * Date: 13/06/2016
 * Time: 15:36
 */

namespace Mdespeuilles\WebformBundle\Services\Twig;

use Mdespeuilles\WebformBundle\Form\WebformType;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class Webform extends \Twig_Extension
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * Webform constructor.
     * @param ContainerInterface $containerInterface
     * @param RequestStack $requestStack
     */
    public function __construct(ContainerInterface $containerInterface, RequestStack $requestStack)
    {
        $this->container = $containerInterface;
        $this->requestStack = $requestStack;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('getForm',  array($this, 'getForm'), array('is_safe' => array('html'))),
        );
    }


    public function getForm($id)
    {
        return $this->container->get('mdespeuilles.webform')->getForm($id);
    }

    public function getName()
    {
        return 'getForm';
    }

    public function generateUrl($route, $parameters = array(), $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH)
    {
        return $this->container->get('router')->generate($route, $parameters, $referenceType);
    }

    public function createForm($type, $data = null, array $options = array())
    {
        return $this->container->get('form.factory')->create($type, $data, $options);
    }
}