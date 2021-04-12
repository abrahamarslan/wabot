<?php


class EmailHelper
{
    /**
     * Validate and sanitize email
     * @param string
     * @return email
     */
    public static function email($email){
        $email=trim($email);
        if (preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]{2,})+$/i', $email) && strlen($email)<=50 && filter_var($email, FILTER_SANITIZE_EMAIL)){
            return filter_var($email, FILTER_SANITIZE_EMAIL);
        }
        return false;
    }


}
