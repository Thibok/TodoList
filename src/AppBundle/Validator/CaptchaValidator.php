<?php

/**
 * Validator for validate Captcha.
 */

namespace AppBundle\Validator;


use ReCaptcha\ReCaptcha;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Captcha Validator
 */
class CaptchaValidator extends ConstraintValidator
{
    /**
     * @var RequestStack
     * @access private
     */
    private $request;

    /**
     * @var Recaptcha
     * @access private
     */
    private $captcha;

    /**
     * Constructor
     *
     * @param RequestStack $request
     * @param string $captchaSecretKey
     * 
     * @return void
     */
    public function __construct(RequestStack $request, $captchaSecretKey)
    {
        $this->request = $request;
        $this->captcha = new ReCaptcha($captchaSecretKey);
    }

    /**
     * Valid value
     * @access public
     * @param string $value
     * @param Constraint $constraint
     * 
     * @return void
     */
    public function validate($value, Constraint $constraint): void
    {
        $currentRequest = $this->request->getCurrentRequest();

        $resp = $this->captcha->verify($value, $currentRequest->getClientIp());

        if (!$resp->isSuccess()) {
            $this->context->addViolation($constraint->message);
        }
        
    }
}