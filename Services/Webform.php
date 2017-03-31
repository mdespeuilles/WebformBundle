<?php
/**
 * Created by PhpStorm.
 * User: maxence
 * Date: 17/03/2017
 * Time: 08:34
 */

namespace Mdespeuilles\WebformBundle\Services;

use Mdespeuilles\WebformBundle\Form\WebformType;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class Webform
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

    public function getForm($id)
    {
        $request = $this->requestStack->getCurrentRequest();

        $webform = $this->container->get("mdespeuilles.entity.webform")->findOneBy([
            'id' => $id
        ]);

        $form = $this->createForm(WebformType::class, null, [
            'action' => $this->generateUrl('webform_submit', [
                'webformId' => $id
            ]),
            'webform' => $webform
        ]);

        return $this->container->get('templating')->render('@MdespeuillesWebform/Twig/webform.html.twig', [
            'form' => $form->createView(),
            'webform' => $webform
        ]);
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