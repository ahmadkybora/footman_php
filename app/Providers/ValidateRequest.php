<?php

namespace App\Providers;

use Illuminate\Database\Capsule\Manager as Capsule;

class ValidateRequest extends ServiceProvider
{
    private static $error = [];
    private static $error_messages = [
        'string' => 'The :attribute field cannot contain numbers',
        'required' => 'The :attribute field is required',
        'minLength' => 'The :attribute field must be a minimum of :policy characters',
        'maxLength' => 'The :attribute filed must be a maximum of :policy characters',
        'mixed' => 'The :attribute filed can contain letters, numbers, dash and space only',
        'numeric' => 'The :attribute filed cannot contain letters e.g 20.0, 20',
        'email' => 'Email address is invalid',
        'unique' => 'The :attribute is already taken, please try another one',
    ];

    /**
     * set specific error
     *
     * @param $error
     * @param null $key
     */
    private static function setError($error, $key = null)
    {
        if($key)
            self::$error[$key][] = $error;

        self::$error[] = $error;
    }

    /**
     * perform validation for the data provider and set error messages
     *
     * @param array $data
     */
    private static function doValidation(array $data)
    {
        $column = $data['column'];
        foreach ($data['rules'] as $rule => $policy)
        {
            $valid = call_user_func_array([self::class, $rule], [$column, $data['value'], $policy]);
            if(!$valid)
            {
                self::setError(
                    str_replace(
                        [':attribute', ':policy', '_'],
                        [$column, $policy, ' '],
                        self::$error_messages[$rule]) ,$column
                );
            }
        }
    }

    /**
     * @param array $dataAndValues, column and value to validate
     * @param array $rules, the rules that validation must satisfy
     */
    public function abide(array $dataAndValues, array $rules)
    {
        foreach ($dataAndValues as $column => $value)
        {
            if(in_array($column, array_keys($rules)))
            {
                self::doValidation(
                    [
                        'column' => $column,
                        'value' => $value,
                        'rules' => $rules[$column]
                    ]
                );
            }
        }
    }

    /**
     * return true if there is validation error
     *
     * @return bool
     */
    public function hasError()
    {
        return count(self::$error) > 0 ? true : false;
    }

    /**
     * return all validation errors
     *
     * @return array
     */
    public function getErrorMessages()
    {
        return self::$error;
    }
    
    /**
     * @param $column, filed name or column
     * @param $value, value passed into the form
     * @param $rule, the rule that e set e.g min = 5
     * @return bool, return true or false
     */
    protected static function unique($column, $value, $rule)
    {
        if($value != null and !empty(trim($value)))
            return !Capsule::table($rule)->where($column, '=', $value)->exists();

        return true;
    }

    /**
     * @param $column
     * @param $value
     * @param $rule
     * @return bool
     */
    protected static function required($column, $value, $rule)
    {
        return $value !== null and !empty(trim($value));
    }

    /**
     * @param $column
     * @param $value
     * @param $rule
     * @return bool
     */
    protected static function minLength($column, $value, $rule)
    {
        if($value != null and !empty(trim($value)))
            return strlen($value) >= $rule;

        return true;
    }

    /**
     * @param $column
     * @param $value
     * @param $rule
     * @return bool
     */
    protected static function maxLength($column, $value, $rule)
    {
        if($value != null and !empty(trim($value)))
            return strlen($value) <= $rule;

        return true;
    }

    /**
     * @param $column
     * @param $value
     * @param $rule
     * @return bool|mixed
     */
    protected static function email($column, $value, $rule)
    {
        if($value != null and !empty(trim($value)))
            return filter_var($value, FILTER_VALIDATE_EMAIL);

        return true;
    }

    /**
     * @param $column
     * @param $value
     * @param $rule
     * @return bool
     */
    protected static function mixed($column, $value, $rule)
    {
        if($value != null and !empty(trim($value)))
        {
            if (!preg_match("/^[A-Za-z0-9 .,_~-!@#&%^'*(\)]+$/", $value))
                return false;
        }

        return true;
    }

    /**
     * @param $column
     * @param $value
     * @param $rule
     * @return bool
     */
    protected static function string($column, $value, $rule)
    {
        if($value != null and !empty(trim($value)))
        {
            if (!preg_match("/^[A-Za-z ]+$/", $value))
                return false;
        }

        return true;
    }

    /**
     * @param $column
     * @param $value
     * @param $rule
     * @return bool
     */
    protected static function numeric($column, $value, $rule)
    {
        if($value != null and !empty(trim($value)))
        {
            if (!preg_match("/^[0-9.]+$/", $value))
                return false;
        }

        return true;
    }
}
