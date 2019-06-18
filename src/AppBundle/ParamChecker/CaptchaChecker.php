<?php

/**
 * Check the captcha
 */

namespace AppBundle\ParamChecker;

use AppBundle\Validator\Captcha;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Captcha Checker
 */
class CaptchaChecker
{
    /**
     * @var ValidatorInterface
     * @access private
     */
    private $validator;

    /**
     * @var RequestStack
     * @access private
     */
    private $request;
    
    /**
     * Constructor
     * @access public
     * @param ValidatorInterface $validator
     * @param RequestStack $requestStack
     * 
     * @return void
     */
    public function __construct(ValidatorInterface $validator, RequestStack $request)
    {
        $this->validator = $validator;
        $this->request = $request;
    }

    /**
     * Check the value of captcha with CaptchaValidator
     * @access public
     * 
     * @return boolean
     */
    public function check()
    {
        $currentRequest = $this->request->getCurrentRequest();
        $captcha = $currentRequest->request->get('g-recaptcha-response');
        $constraint = new Captcha;

        $errors = $this->validator->validate($captcha, $constraint);

        if (count($errors) != 0) {
            $currentRequest->getSession()->getFlashBag()->add('error', $constraint->message);
            return false;
        }

        return true;
    }
}