<?php

if (!function_exists('appIsRunningUnitTests')) {
    function appIsRunningUnitTests(): bool
    {
        return env('APP_IS_RUNNING_UNIT_TESTS', false) === true;
    }
}
