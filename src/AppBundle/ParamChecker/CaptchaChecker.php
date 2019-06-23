<?php
declare(strict_types=1);

/**
 * Check the captcha
 */

namespace AppBundle\ParamChecker;

use AppBundle\Validator\Captcha;
use Symfony\Component\HttpFoundation\Request;
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
     * @var string
     * @access private
     */
    private $env;
    
    /**
     * Constructor
     * @access public
     * @param ValidatorInterface $validator
     * @param string $env
     * 
     * @return void
     */
    public function __construct(ValidatorInterface $validator, $env)
    {
        $this->validator = $validator;
        $this->env = $env;
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

        if ($this->env != 'test') {
            $errors = $this->validator->validate($captcha, $constraint);

            if (count($errors) != 0) {
                $request->getSession()->getFlashBag()->add('error', $constraint->message);
                return false;
            }
        }

        return true;
    }
}