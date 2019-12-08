<?php

namespace App\Http\Requests;

use Illuminate\Http\JsonResponse;
use Validator,
    Response;

class FormRequest {

    /**
     * @var array
     */
    protected $input;

    /**
     * @var array
     */
    protected $rules = [];

    /**
     * @var \Illuminate\Validation\Validator
     */
    protected $validator;

    /**
     * @param array $input
     */
    public function __construct(array $input) {
        $this->validator = Validator::make($input, $this->rules);
    }

    /**
     * @return \Illuminate\Validation\Validator
     */
    public function getValidator() {
        return $this->validator;
    }

    /**
     * @param array $rules
     */
    public function setRules(array $rules) {
        $this->rules = $rules;
    }

    /**
     * @param string $name
     * @param array $rules
     */
    public function setRule($name, array $rules) {
        $this->rules[$name] = $rules;
    }

    /**
     * @return array
     */
    public function getRules() {
        return $this->rules;
    }

    /**
     * @return array
     */
    public function getInput() {
        return $this->input;
    }

    /**
     * @param $input
     */
    public function setInput($input) {
        $this->input = $input;
    }

    /**
     * @return array
     */
    public function getRequest() {
        return $this->input;
    }

    /**
     * @return JsonResponse
     */
    public function failResponse() {
        $success = false;
        $error = $this->validator->messages();

        return Response::json(compact('success', 'error'));
    }

    public function getError() {
        return $this->validator->messages();
    }

    /**
     * @return bool
     */
    public function fails() {
        return $this->validator->fails();
    }
}
