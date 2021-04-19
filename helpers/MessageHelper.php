<?php


class MessageHelper
{

    public static function hasLastSentMessage($phoneNumber) {
        try {

        } catch (Exception $e) {

        }
    }
    /**
     *
     * @param $haystack
     * @param $needle
     * @return bool
     */
    public static function startsWith($haystack, $needle)
    {
        return !strncmp($haystack, $needle, strlen($needle));
    }

    /**
     * @param $haystack
     * @param $needle
     * @return bool
     */

    public static function endsWith($haystack, $needle)
    {
        $length = strlen($needle);

        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }
}
