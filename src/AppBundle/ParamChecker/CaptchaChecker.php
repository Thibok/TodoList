<?php
declare(strict_types=1);

/**
 * Check the captcha
 */

namespace AppBundle\ParamChecker;

use AppBundle\Validator\Captcha;
use Symfony\Component\HttpFoundation\Request;
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
     * Constructor
     * @access public
     * @param ValidatorInterface $validator
     * 
     * @return void
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Check the value of captcha with CaptchaValidator
     * @access public
     * 
     * @return boolean
     */
    public function check(Request $request): bool
    {
        $captcha = $request->get('g-recaptcha-response');
        $constraint = new Captcha;

        $errors = $this->validator->validate($captcha, $constraint);

        if (count($errors) != 0) {
            $request->getSession()->getFlashBag()->add('error', $constraint->message);
            return false;
        }
        
        return true;
    }
}