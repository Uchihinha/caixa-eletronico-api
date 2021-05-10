<?php
namespace App\Traits;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

trait ValidateRequest
{
    public function validate(array $request, array $rules) {
        $validator = Validator::make($request, $rules);

        if ($validator->fails()) throw new ValidationException($validator);

        return $validator;
    }
}
