<?php

namespace mindplay\kissform\Validators;

use mindplay\kissform\Facets\FieldInterface;
use mindplay\kissform\Facets\TokenServiceInterface;
use mindplay\kissform\Facets\ValidatorInterface;
use mindplay\kissform\InputModel;
use mindplay\kissform\InputValidation;
use mindplay\lang;

/**
 * This validator is auto-generated by TokenField - you can validate the CSRF token by
 * simply calling Validation::check() with your TokenField instance, it will create the
 * CheckToken validator automatically. See "examples/demo.php" for a working sample.
 */
class CheckToken implements ValidatorInterface
{
    /**
     * @var TokenServiceInterface
     */
    private $service;

    /**
     * @var string|null
     */
    private $error;

    /**
     * @param TokenServiceInterface $service
     * @param string|null           $error optional custom error message
     */
    public function __construct(TokenServiceInterface $service, $error = null)
    {
        $this->service = $service;
        $this->error = $error;
    }

    public function validate(FieldInterface $field, InputModel $model, InputValidation $validation)
    {
        $input = $model->getInput($field);
        
        if ($input === null) {
            $model->setError($field, $this->error ?: lang::text("mindplay/kissform", "noToken"));
        }

        if (! $this->service->checkToken($field->getName(), $input)) {
            $model->setError($field, $this->error ?: lang::text("mindplay/kissform", "token"));
        }
    }
}
