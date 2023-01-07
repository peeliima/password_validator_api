<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PasswordController extends Controller
{
    public function passwordValidator(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'rules' => 'required'
        ]);

        if ($validator->fails()) {
			$error = $validator->errors()->first();
			return response([
				'error_code' => 'form_error',
				'message' => $error,
			], 400);
		}

        $http_code = 200;
        $validate = true;
        $errors = [];

        foreach ($request->rules as $rule) {
            $method_name = $rule['rule'];
            $value = $rule['value'];

            $response = $this->$method_name($request->password, $value);

            if (!$response) {
                $errors[] = $method_name; 
            }

            if (!empty($errors)) {
                $http_code = 400;
                $validate = false;
            }
        }

        return response ([
            'verify' => $validate,
            'noMatch' => $errors
        ], $http_code);
    }

    private function minSize($password, $value)
    {
        if (mb_strlen($password) < $value) {
            return false;
        }

        return true;
    }

    private function minUppercase($password, $value)
    {
        $count = 0;

        $password_lenght = mb_strlen($password);

        for ($i=0; $i < $password_lenght; $i++) {
            $explode_password = substr($password, $i, 1);

            $validate = ctype_upper($explode_password);

            if ($validate == true) {
                $count++;
            }
        }

        if ($count < $value) {
            return false;
        }

        return true;
    }
}
