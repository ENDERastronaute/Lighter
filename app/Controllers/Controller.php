<?php

namespace App\Controllers;

class Controller
{
    protected static $fields;

    protected static function validate(array $fields)
    {
        Controller::$fields = $fields;

        $input = $_POST;

        if (!Controller::checkFields($input)) {
            return false;
        }

        return true;
    }

    private static function checkFields(array $input) {
        foreach (Controller::$fields as $key => $value) {
            foreach ($value as $requirement) {
                if ($requirement === 'required') {
                    if (!Controller::required($input[ $key ])) {
                        return false;
                    }
                }

                if ($requirement === 'email') {
                    if (!Controller::email($input[ $key ])) {
                        return false;
                    }
                }
            }
        }

        return true;
    }
    private static function required($value) {
        if (is_null($value) || $value === '') {
            return false;
        }

        return true;
    }
    private static function email($value) {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return true;
    }
}