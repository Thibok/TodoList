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
     * @var string
     * @access private
     */
    private $env;

    /**
     * Constructor
     *
     * @param RequestStack $request
     * @param string $captchaSecretKey
     * @param string $env
     * 
     * @return void
     */
    public function __construct(RequestStack $request, $captchaSecretKey, $env)
    {
        $this->request = $request;
        $this->captcha = new ReCaptcha($captchaSecretKey);
        $this->env = $env;
    }

    /**
     * Valid value
     * @access public
     * @param string $value
     * @param Constraint $constraint
     * 
     * @return void
     */
    public function validate($value, Constraint $constraint)
    {
        $currentRequest = $this->request->getCurrentRequest();

        if ($this->env != 'test') {
            $resp = $this->captcha->verify($value, $currentRequest->getClientIp());

            if (!$resp->isSuccess()) {
                $this->context->addViolation($constraint->message);
            }
        }
    }
}