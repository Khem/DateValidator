<?php

/**
 * Class to validate date
 * accepts input date format that matches the date separator pattern #[-./]#
 * checks for valid month, date and year in all combinations
 * validates as true if any of the combinations is valid
 */

class DateValidator
{
    /**
     * @var string
     */
    private static $pattern = "#[-./]#";

    /**
     * @var string
     */
    protected static $date;

    /**
     * @var array
     */
    private static $dateAttributes = array();

    /**
     * @var array
     */
    private static $dateAttributesCombinations = array();

    /**
     * @var boolean
     */
    private static $isValid = false;

    /**
     * @return void
     */
    private static function parseDate()
    {
        self::$dateAttributes = preg_split(self::$pattern, self::$date);
    }

    /**
     * @return void|boolean
     */
    private static function validate()
    {
        // if pattern does not not match return false straightway
        if (!preg_match(self::$pattern, self::$date)) {
            return false;
        }

        static::parseDate();
        static::setAllCombination(self::$dateAttributes);
        static::checkAllCombinations();
    }

    /**
     * @param array
     * @param array
     * @return void
     */
    private static function setAllCombination($items, $perms = array())
    {
        if (empty($items)) {
            array_push(self::$dateAttributesCombinations, $perms);
        } else {
            for ($i = count($items) - 1; $i >= 0; --$i) {
                $newitems = $items;
                $newperms = $perms;
                list($value) = array_splice($newitems, $i, 1);
                array_unshift($newperms, $value);
                static::setAllCombination($newitems, $newperms);
            }
        }
    }

    /**
     * @return void|
     */
    private static function checkAllCombinations()
    {
        foreach (self::$dateAttributesCombinations as $value) {
            // if any values are not numeric assign 0 to fail
            $month = is_numeric($value[0])?$value[0]:0;
            $day   = is_numeric($value[1])?$value[1]:0;
            $year  = is_numeric($value[2])?$value[2]:0;

            if (checkdate($month, $day, $year) === true ) {
                self::$isValid = true;
                return;
            }
        }
    }

    /**
     * @param string
     * @return boolean
     */
    public static function isValidDate($date)
    {
        self::$date = $date;

        static::validate();

        return self::$isValid;
    }

}
