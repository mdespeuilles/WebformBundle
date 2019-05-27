<?php


namespace Mdespeuilles\WebformBundle\Constraints;


use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class RecaptchaValidator extends ConstraintValidator
{
    private $requestStack;

    private $recaptcha;

    public function __construct(RequestStack $requestStack, \ReCaptcha\ReCaptcha $reCaptcha)
    {
        $this->requestStack = $requestStack;
        $this->recaptcha = $reCaptcha;
    }

    public function validate($value, Constraint $constraint)
    {
        $request = $this->requestStack->getCurrentRequest();
        $recaptchaResponse = $request->request->get('g-recaptcha-response');
        if (empty($recaptchaResponse)) {
            $this->context->buildViolation($constraint->message)->addViolation();
            return;
        }

        $response = $this->recaptcha->setExpectedHostname($request->getHost())->verify($recaptchaResponse, $request->getClientIp());

        if (!$response->isSuccess()) {
            $this->context->buildViolation($constraint->message)->addViolation();
            return;
        }
    }
}
