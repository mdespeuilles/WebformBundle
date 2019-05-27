<?php
/**
 * Created by PhpStorm.
 * User: maxence
 * Date: 13/03/2017
 * Time: 19:26
 */

namespace Mdespeuilles\WebformBundle\Controller;

use Mdespeuilles\WebformBundle\Entity\WebformSubmission;
use Mdespeuilles\WebformBundle\Form\WebformType;
use AppBundle\Services\FormError;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class WebformController extends Controller  {

    public function indexAction(Request $request, $slug) {
        $webform = $this->get("mdespeuilles.entity.webform")->findOneBy([
            'slug' => $slug
        ]);

        if (!$webform) {
            throw new NotFoundHttpException();
        }

        return $this->render('MdespeuillesWebformBundle:Webform:index.html.twig', array(
            "webform" => $webform
        ));
    }


    public function submitAction(Request $request, $webformId) {
        $webform = $this->get("mdespeuilles.entity.webform")->findOneBy([
            'id' => $webformId
        ]);

        $form = $this->createForm(WebformType::class, null, [
            'webform' => $webform
        ]);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $webformSubmission = new WebformSubmission();
                $webformSubmission->setWebform($webform);

                $data = [];

                foreach ($form->all() as $key => $field) {
                    /* @var \Symfony\Component\Form\Form $field */
                    if ($field->getName() != "submit") {
                        $data[$field->getName()] = $field->getData();
                    }
                }

                $webformSubmission->setData($data);

                $em = $this->getDoctrine()->getManager();
                $em->persist($webformSubmission);
                $em->flush();

                foreach ($webform->getMails() as $email) {
                    $this->get('mdespeuilles.mail')->sendMail($webform->getEmailTemplate()->getMachineName(), $webform->getSenderMail(),  $email, [
                        'webform_data' => $data
                    ]);
                }

                if ($webform->isUseAjax()) {
                    $response = new JsonResponse();
                    $response->setData($webform->getConfirmationMessage());
                    return $response;
                }
            }
            else {
                if ($webform->isUseAjax()) {
                    $errors = FormError::getErrors($form);
                    $response = new JsonResponse();
                    $response->setStatusCode(412);
                    $response->setData([
                        'errorMessage' => $errors
                    ]);
                    return $response;
                }
            }
        }
    }
}