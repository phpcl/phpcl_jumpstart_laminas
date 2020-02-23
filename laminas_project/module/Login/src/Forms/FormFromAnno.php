<?php
namespace Login\Forms;

use Laminas\Form\Annotation as ANO;

/**
 * @ANO\Name("login-form-from-anno")
 */
class FormFromAnno
{
    /**
     * @ANO\Type("Laminas\Form\Element\Email")
     * @ANO\Options({"label":"Email"})
     * @ANO\Attributes({"size":40,"placeholder":"Use your email address as a login name"})
     */
    public $email;
    /**
     * @ANO\Type("Laminas\Form\Element\Password")
     * @ANO\Options({"label":"Password"})
     * @ANO\Attributes({"size":20})
     */
    public $pwd;
    /**
     * @ANO\Type("Laminas\Form\Element\Submit")
     * @ANO\Attributes({"value":"Login"})
     */
    public $submit;
}
