<?php

/**
 * Dumps the value then dies
 *
 * @param mixed $anything Any variable, object, array. Can take multiple parameters as well
 *
 * @return void
 */
function dd($anything)
{
    $args = func_get_args();
    echo '<pre>';
    foreach ($args as $arg) {
        /** @noinspection ForgottenDebugOutputInspection */
        var_dump($arg);
    }
    echo '</pre>';
    die;
}


/**
 * Dumps the value then dies
 *
 * @param mixed $anything Any variable, object, array. Can take multiple parameters as well
 *
 * @return void
 */
function ds($anything)
{
    $args = func_get_args();
    echo '<pre>';
    foreach ($args as $arg) {
        /** @noinspection ForgottenDebugOutputInspection */
        print_r($arg);
    }
    echo '</pre>';
}


/**
 * Dumps the value then dies
 *
 * @param mixed $anything Any variable, object, array. Can take multiple parameters as well
 *
 * @return void
 */
function dp($anything)
{
    ds($anything);
    die;
}


/**
 * Dumps the parameters as json
 *
 * @param $anything
 *
 * @return void
 */
function dj($anything)
{
    $args = func_get_args();
    echo json_encode($args);
    die;
}


/**
 * Return the value of the given parameter
 *
 * @param  mixed $value
 *
 * @return mixed
 */
function value($value)
{
    return $value instanceof Closure ? $value() : $value;
}


/**
 * Get an item from an array using "dot" notation.
 *
 * @param  array   $array
 * @param  string  $key
 * @param  mixed   $default
 *
 * @return mixed
 */
function array_get($array, $key, $default = null)
{
    if ($key === null) {
        return $array;
    }

    // To retrieve the array item using dot syntax, we'll iterate through
    // each segment in the key and look for that value. If it exists, we
    // will return it, otherwise we will set the depth of the array and
    // look for the next segment.
    foreach (explode('.', $key) as $segment) {
        if (!is_array($array) || !array_key_exists($segment, $array)) {
            return value($default);
        }

        $array = $array[$segment];
    }

    return $array;
}


/**
 * Set an array item to a given value using "dot" notation.
 *
 * If no key is given to the method, the entire array will be replaced.
 *
 * @param  array   $array
 * @param  string  $key
 * @param  mixed   $value
 *
 * @return void
 */
function array_set(&$array, $key, $value)
{
    if ($key === null) {
        $array = $value;

        return;
    }

    $keys = explode('.', $key);

    // This loop allows us to dig down into the array to a dynamic depth by
    // setting the array value for each level that we dig into. Once there
    // is one key left, we can fall out of the loop and set the value as
    // we should be at the proper depth.
    while (count($keys) > 1) {
        $key = array_shift($keys);

        // If the key doesn't exist at this depth, we will just create an
        // empty array to hold the next value, allowing us to create the
        // arrays to hold the final value.
        if (!isset($array[$key]) || !is_array($array[$key])) {
            $array[$key] = [];
        }

        $array =& $array[$key];
    }

    $array[array_shift($keys)] = $value;
}


/**
 * Format the microtime float falue to ms with 2 decimals
 *
 * @param float $time
 *
 * @return float
 */
function convertMicrotime($time)
{
    return round($time * 1000, 2);
}


/**
 * Evaulate the string content to bool value if possible
 *
 * @param string $string
 * @param mixed  $default
 *
 * @return mixed
 */
function evaluate($string, $default = null)
{
    if (in_array($string, ['yes', 'true', 'igen', '1'], true)) {
        return true;
    }

    if (in_array($string, ['no', 'false', 'nem', '0'], true)) {
        return false;
    }

    return $default ?: $string;
}


/**
 * Return the property or value of the key for each value of the array
 *
 * @param array[]|stdClass[] $array
 * @param string             $property
 *
 * @return array
 */
function array_pluck(array $array, $property)
{
    return array_map(
        function($element) use ($property) {
            if (is_array($element)) {
                return $element[$property];
            }

            if (is_object($element)) {
                return $element->$property;
            }

            throw new ErrorException('Array_pluck got neither array nor object!');

        },
        $array
    );
}


/**
 * Pull the value from the array. Afterwards it won't be accessible
 *
 * @param array      $array
 * @param int|string $key
 *
 * @return mixed
 */
function array_pull(array &$array, $key)
{
    $value = $array[$key];
    unset($array[$key]);

    return $value;
}


/**
 * Return the actual date as a DateTimeImmutable object
 *
 * @return DateTimeImmutable
 */
function today()
{
    return new \DateTimeImmutable('today');
}


/**
 * Return the actual date and time as a DateTimeImmutable object
 *
 * @return DateTimeImmutable
 */
function now()
{
    return new \DateTimeImmutable();
}
