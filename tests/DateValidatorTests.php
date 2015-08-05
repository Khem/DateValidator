<?php

require_once('../DateValidator.php');

class DateValidatorTests extends PHPUnit_Framework_TestCase
{
    public function testIsValidDate()
    {
        $isValid = DateValidator::isValidDate('2014-12-12');
        $this->assertEquals(true, $isValid);
    }
}