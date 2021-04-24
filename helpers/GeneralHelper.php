<?php

use Carbon\Carbon;

class GeneralHelper
{
    /*
        @abstract Generate a alphanum id in the given length
        @example  string_rand(128)
        @param    int $length (no max. length) [default=8]
        @return   string $alphanum
        @link     http://php.net/manual/en/function.rand.php
        @todo     Optional Return Array without Duplicates?
        @version  1.0
    */
    public static function string_rand($length=8){
        $char = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        srand((double)microtime()*1000000); # 1 Mio.
        $return = '';
        for($i=0; $i< $length; $i++) {
            $return .= $char[rand()%strlen($char)];
        }
        return $return;
    }

    /*
	@abstract Generate a readable word in the given length
	@example  string_rand_readable(12)
	@param    int $length [default=8]
	@return   string $word
	@link     http://php.net/manual/en/function.rand.php
	@todo     Optional Return Array without Duplicates?
	@version  1.0
    */
    public static function string_rand_readable($length=8){ // NO q?
        $conso  = array("b","c","d","f","g","h","j","k","l","m","n","p","r","s","t","v","w","x","y","z");
        $vocal  = array("a","e","i","o","u");
        $output = '';
        srand((double)microtime()*1000000); // 1 Mio.
        $max = $length/2;
        for($i=1; $i<=$max; $i++){
            $output .= $conso[rand(0,19)];
            $output .= $vocal[rand(0,4)];
        }
        return $output;
    }

    /**
     * Generate Open-graph tags
     * @param none
     * @return string
     * @since v1.0
     */
    public static function ogp(){
        $meta="<meta property=\"og:type\" content=\"website\" />\n\t";
        $meta.="<meta property=\"og:url\" content=\"".self::url()."\" />\n\t";
        $meta.="<meta property=\"og:title\" content=\"".self::title()."\" />\n\t";
        $meta.="<meta property=\"og:description\" content=\"".self::description()."\" />\n\t";
        $meta.="<meta property=\"og:image\" content=\"".self::image()."\" />\n";
        if(!empty(self::$video)){
            $meta.=self::$video;
        }
        echo $meta;
    }

    /**
     * Generate api or random string
     * @param length, start
     * @return
     */
    public static function strrand($length=12,$api=""){
        $use = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
        srand((double)microtime()*1000000);
        for($i=0; $i<$length; $i++) {
            $api.= $use[rand()%strlen($use)];
        }
        return $api;
    }

    /**
     * Convert a timestap into timeago format
     * @param time
     * @return timeago
     */

    public static function timeago($time, $tense=TRUE){
        try
        {
            $time=strtotime($time);
            $periods = array(e("second"), e("minute"), e("hour"), e("day"), e("week"), e("month"), e("year"), e("decade"));
            $lengths = array("60","60","24","7","4.35","12","10");
            $now = time();
            $difference = $now - $time;
            $tense= e("ago");
            for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
                $difference /= $lengths[$j];
            }
            $difference = round($difference);
            if($difference != 1) {
                $periods[$j].= "s";
            }
            if($tense){
                return "$difference $periods[$j] $tense ";
            }else{
                return $difference;
            }
        } catch (Exception $e)
        {
            return '';
        }

    }


    /**
     * Format Number
     * @param number, decimal
     * @return formatted number
     */
    public static function formatnumber($number,$decimal="0") {
        if($number>1000000000000) $number= round($number /1000000000000, $decimal)."T";
        if($number>1000000000) $number= round($number /1000000000, $decimal)."B";
        if($number>1000000) $number= round($number /1000000, $decimal)."M";
        if($number>10000) $number= round($number /10000, $decimal)."K";

        return $number;
    }


    /**
     * Is Set and Equal to
     * @param key, value
     * @return boolean
     */
    public static function is_set($key,$value=NULL,$method="GET"){
        if(!in_array($method, array("GET","POST"))) return FALSE;
        if($method=="GET") {
            $method=$_GET;
        }elseif($method=="POST"){
            $method=$_POST;
        }
        if(!isset($method[$key])) return FALSE;
        if(!is_null($value) && $method[$key]!==$value) return FALSE;
        return TRUE;
    }

    /**
     * Validate and sanitize username
     * @param string
     * @return username
     */

    public static function username($user){
        if(preg_match('/^\w{4,}$/', $user) && strlen($user)<=20 && filter_var($user,FILTER_SANITIZE_STRING)) {
            return filter_var(trim($user),FILTER_SANITIZE_STRING);
        }
        return false;
    }


    /**
     * Validate Date
     * @param string
     */
    public static function validatedate($date, $format = 'Y-m-d H:i:s'){
        if(!class_exists("DateTime")){
            if(!preg_match("!(.*)-(.*)-(.*)!",$date)) return false;
            return true;
        }
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }


    /**
     * Get IP
     * @since 1.0
     **/
    public static function ip(){
        $ipaddress = '';
        if(isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
            $ipaddress =  $_SERVER['HTTP_CF_CONNECTING_IP'];
        } else if (isset($_SERVER['HTTP_X_REAL_IP'])) {
            $ipaddress = $_SERVER['HTTP_X_REAL_IP'];
        }
        else if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    /**
     * Validate URLs
     * @since 1.0
     **/
    public static function is_url($url){
        if (preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$url) && filter_var($url, FILTER_VALIDATE_URL)){
            return true;
        }
        return false;
    }

    /**
     * Encode string
     * @param string, encode= MD5, SHA1 or SHA256
     * @return hash
     */
    public static function encode($string,$encoding="phppass"){
        if($encoding=="phppass"){
            if(!class_exists("PasswordHash")) require_once(ROOT."/includes/library/phpPass.class.php");
            $e = new PasswordHash(8, FALSE);
            return $e->HashPassword($string.self::$config["security"]);
        }else{
            return hash($encoding,$string.self::$config["security"]);
        }
    }


    /**
     * Check Password
     * @param string, encode= MD5, SHA1 or SHA256
     * @return hash
     */
    public static function validate_pass($string,$hash,$encoding="phppass"){

        if($encoding=="phppass"){
            if(!class_exists("PasswordHash")) require_once(ROOT."/includes/library/phpPass.class.php");
            $e = new PasswordHash(8, FALSE);
            return $e->CheckPassword($string.self::$config["security"], $hash);
        }else{
            return hash($encoding,$string.self::$config["security"]);
        }
    }


    /**
     * @param $str
     * @param string $separator
     * @param bool $lowercase
     * @return string
     */
    public static function sluggifyURL($str, $separator = 'dash', $lowercase = FALSE)
    {
        if ($separator == 'dash')
        {
            $search		= '_';
            $replace	= '-';
        }
        else
        {
            $search		= '-';
            $replace	= '_';
        }

        $trans = array(
            '&\#\d+?;'				=> '',
            '&\S+?;'				=> '',
            '\s+'					=> $replace,
            '[^a-z0-9\-\._]'		=> '',
            $replace.'+'			=> $replace,
            $replace.'$'			=> $replace,
            '^'.$replace			=> $replace,
            '\.+$'					=> ''
        );

        $str = strip_tags($str);

        foreach ($trans as $key => $val)
        {
            $str = preg_replace("#".$key."#i", $val, $str);
        }

        if ($lowercase === TRUE)
        {
            $str = strtolower($str);
        }

        return trim(stripslashes(strtolower($str)));
    }

    /**
     * Check if the logged in User created the record in the table
     * @param $tableName
     * @param $tablePK
     * @param $recordID
     * @param $userFK
     * @return bool
     */
    public function checkOwner($tableName, $tablePK, $recordID, $userFK)
    {
        try {
            if ($user = Sentinel::check()) {
                $record = DB::table($tableName)->where($tablePK, '=', $recordID)->where($userFK, '=', $user->getUserId())->first();
                if ($record) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }

        } catch (\Exception $e) {
            //User is not authenticated
            return false;
        }
    }


    /**
     * Toggle status
     * @param $tableName
     * @param $rowID
     * @param $statusColumn
     * @return bool
     */
    public static function toggleStatus($tableName, $rowID, $statusColumn)
    {
        $toggle = null;
        $row = DB::table($tableName)->where('id','=',$rowID)->first();
        if(!empty($row->{$statusColumn}))
        {
            if($row->{$statusColumn} == 'active')
            {
                //Update to Inactive
                $toggle = DB::table($tableName)->where('id','=',$rowID)->update([$statusColumn => 'inactive']);
            } elseif ($row->{$statusColumn}=='inactive')
            {
                //Update to Active
                $toggle = DB::table($tableName)->where('id','=',$rowID)->update([$statusColumn => 'active']);
            } else {
                //Update to Active
                $toggle = DB::table($tableName)->where('id','=',$rowID)->update([$statusColumn => 'active']);
            }
            return true;
        } else {
            return false;
        }
    }


    /**
     * Make Image Preview
     * @param $img
     * @param null $type
     * @param $folder
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\UrlGenerator|string
     */

    public static function makepreview($img, $type = null, $folder)
    {

        if($type !== null){
            $type="-$type.jpg";
        }

        if($img == null or $img == ''){
            $img="default_holder";
        }elseif(substr($img,0,6)=="https:" || substr($img,0,5)=="http:"){

            $pos=strpos($img, "amazon");
            if ($pos !== false)
            {
                return url($img.$type);
            }

            return $img;
        }

        return "/upload/media/".$folder."/".$img.$type;
    }

    /**
     * Write to a configuration file
     * @param $key
     * @param $int
     * @return bool
     * @throws Exception
     */
    public static function writeConfig($key, $int) {
        $lines = self::parseEnv(base_path('.env'));
        $data = [
            self::formateKey($key) 		=> '"'.$int.'"',
        ];

        $lines = array_merge($lines, $data);

        $fp = @fopen(base_path('.env'), 'w+');
        if(!$fp)
            throw new Exception('Error');

        foreach($lines AS $key => $data) {
            if(is_int($key)) {
                fwrite($fp, implode('',["\n"]));
            } else {
                fwrite($fp, implode('',[$key,'=',$data,"\n"]));
            }
        }
        fclose($fp);
        return true;
    }

    /**
     * Parse Env File
     * @param $path
     * @return array
     */
    public static function parseEnv($path) {
        if(!file_exists($path) || !is_file($path))
            return [];
        $lines = array_map('trim', file($path));
        $result = [];
        foreach($lines AS $row => $line) {
            $parts = explode('=', $line, 2);
            $result[$parts[0] ? : $row] = isset($parts[1]) ? $parts[1] : '';
        }
        return $result;
    }

    /**
     * CURL a URL to get information
     * @param $site
     * @return bool|mixed
     */
    public static function curlit($site)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $site);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $site = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if($httpCode == 404) {
            return false;
        }
        return $site;
    }

    /**
     * Check host
     * @param $secone
     * @return bool
     */
    public static function rop($secone)
    {
        if ($secone==$_SERVER['HTTP_HOST']){;
            return true;
        }else{
            return false;
        }
    }

    /**
     * Filter empty array values
     * @param $array
     * @return array|null
     */
    public static function filterEmptyArray($array)
    {
        if(is_array($array))
        {
            $filteredarray = array_values( array_filter($array));
            return $filteredarray;
        } else {
            return null;
        }
    }


    /**
     * Merge two arrays into one, removing duplicates
     * @param $array1
     * @param $array2
     * @return array|null
     */
    public static function arrayMerge($array1, $array2)
    {
        $resultArray = null;
        if(is_array($array1 && is_array($array2)))
        {
            $resultArray = array_unique(array_merge($array1,$array2), SORT_REGULAR);
        } else {
            $resultArray = null;
        }
        return $resultArray;
    }

    /**
    @abstract Reduce a string by the end, keeps whole words together
    @example  string_truncate('This is a very long test sentence, bla foo bar nothing!',20)
    @param    string $string
    @param    int $limit
    @param    string $break [',' or '.' or ' ' - default=' ']
    @param    string $pad ['' or '...' or '&hellip;' - default='&hellip;']
    @return   string
    @link     http://php.net/manual/en/function.substr.php - http://php.net/manual/en/function.str-replace.php
    @todo     -
    @version  1.0
     */
    public static function string_truncate_old($string, $limit, $break=' ', $pad="&hellip;"){
        if(strlen($string) <= $limit)return $string;
        if(false !== ($breakpoint = strpos($string, $break, $limit))) {
            if($breakpoint < strlen($string) - 1) {
                $string = substr($string, 0, $breakpoint) . $pad;
            }
        }
        return $string;
    }

    /**
     * Truncate String - Advanced
     * @param $string
     * @param $max_length
     * @param bool $wordsafe
     * @param bool $add_ellipsis
     * @param int $min_wordsafe_length
     * @return mixed|string
     */
    public static function string_truncate($string, $max_length, $wordsafe = FALSE, $add_ellipsis = TRUE, $min_wordsafe_length = 1) {
        $ellipsis = '';
        $max_length = max($max_length, 0);
        $min_wordsafe_length = max($min_wordsafe_length, 0);

        if (self::drupal_strlen($string) <= $max_length) {
            // No truncation needed, so don't add ellipsis, just return.
            return $string;
        }

        if ($add_ellipsis) {
            // Truncate ellipsis in case $max_length is small.
            $ellipsis = '...';
            $max_length -= self::drupal_strlen($ellipsis);
            $max_length = max($max_length, 0);
        }

        if ($max_length <= $min_wordsafe_length) {
            // Do not attempt word-safe if lengths are bad.
            $wordsafe = FALSE;
        }

        if ($wordsafe) {
            $matches = array();
            // Find the last word boundary, if there is one within $min_wordsafe_length
            // to $max_length characters. preg_match() is always greedy, so it will
            // find the longest string possible.
            $found = preg_match('/^(.{' . $min_wordsafe_length . ',' . $max_length . '})[' . PREG_CLASS_UNICODE_WORD_BOUNDARY . ']/u', $string, $matches);
            if ($found) {
                $string = $matches[1];
            }
            else {
                $string = self::drupal_substr($string, 0, $max_length);
            }
        }
        else {
            $string = self::drupal_substr($string, 0, $max_length);
        }

        if ($add_ellipsis) {
            $string .= $ellipsis;
        }

        return $string;
    }

    /**
    @abstract Convert &amp;amp; to &
    @example  string_rehtmlentities('Me &amp;amp; You')
    @param    string $html
    @return   string
    @link     http://php.net/manual/de/function.get-html-translation-table.php
    @todo     -
    @version  1.0
     */
    public static function string_rehtmlentities($html){
        $array = get_html_translation_table(HTML_ENTITIES);
        $array = array_flip($array);
        $return = strtr($html, $array);
        $return = utf8_encode($return);
        return $return;
    }

    /**
    @abstract Give a random id (num or alphanum) in the defined length
    @example  string_rand_id(100,true)
    @param    int $length (max. 33) [default=8]
    @param    bool $alphanum [default=false]
    @return   string $rand_id
    @link     http://php.net/manual/en/function.uniqid.php
    @todo     Generate IDs longer than 33 Chars (e.g. with openssl_random_pseudo_bytes)
    @version  3.0
     */

    public static function string_rand_id($length=8,$alphanum=false){
        if($length>33)$length=33;
        list($usec, $sec) = explode(' ', microtime());
        mt_srand((float) $sec + ((float) $usec * 100000));
        $rand_string = uniqid(mt_rand(), true);
        if($alphanum==true)$rand_string = md5(uniqid(mt_rand(), true)); // ONLY FOR ALPHANUM IDs
        $return = substr($rand_string,0,$length);
        return $return;
    }

    /**
    @abstract Make HTML Link fro a given URL (http,https,ftp,mailto or news) only www. URL will not work
    @example  string_makelink('http://www.exmple.com')
    @param    string $URL
    @return   string HTML-Link
    @link     http://php.net/manual/en/function.preg-replace.php
    @todo     Add Option for style or class
    @version  1.0
     */

    public static function string_makelink($string,$attribute='style="text-decoration:underline;"'){
        $pattern = '#(^|[^\"=]{1})(http://|https://|ftp://|mailto:|news:)([^\s<>]+)([\s\n<>]|$)#sm';
        return preg_replace($pattern,"\\1<a ".$attribute." href=\"\\2\\3\">\\2\\3</a>\\4",$string);
    }

    /**
    @abstract Convert an HTML string into plain text
    @example  string_html2text(file_get_contents('http://www.example.com/'))
    @param    string $string The HTML text to convert
    @return   string
    @link     http://php.net/manual/en/function.ctype-digit.php
    @todo     -
    @version  2.0
     */

    public static function string_html2text($html){
        return preg_replace('/\s+/', ' ',
            html_entity_decode(
                trim(strip_tags(preg_replace('/<(head|title|style|script)[^>]*>.*?<\/\\1>/si', '', $html))),
                ENT_QUOTES,
                ini_get("default_charset")
            )
        );
    }

    /**
    @abstract Encrypt a given string with a sepecial $key
    @example  string_encrypt('Lorem Ipum Dolore','adilbo')
    @param    string $string
    @param    string $key
    @return   string
    @link     http://php.net/manual/en/function.mcrypt-encrypt.php
    @todo     -
    @version  1.0
     */

    public static function string_encrypt($string, $key){
        if(function_exists('get_loaded_extensions')){
            if( in_array('mcrypt', get_loaded_extensions()) ){
                $string = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5($key) ) );
                #return gzcompress($string);
                return $string;
            }
        }
        return '---';
    }

    /**
    @abstract Decrypt a given string with a sepecial $key
    @example  string_decrypt('tBPfKi/6F2Wa0+PNbgD7l5ez7ME64bfnVzw3DaRPxgI=','adilbo')
    @param    string $string
    @param    string $key
    @return   string
    @link     http://php.net/manual/en/function.mcrypt-decrypt.php
    @todo     -
    @version  1.0
     */

    public static function string_decrypt($string, $key){
        if(function_exists('get_loaded_extensions')){
            if( in_array('mcrypt', get_loaded_extensions()) ){
                $string = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5($key), base64_decode($string), MCRYPT_MODE_CBC, md5($key) ), "\0" );
                return $string;
            }
        }
        return '---';
    }

    /**
    @abstract Clean string of HTML Tags and XSS
    @example  string_clean('&lt;scr&lt;script>....&lt;/script>ipt>alert(\"XSS\");&lt;/script>')
    @param    string|array $html
    @return   string $text
    @link     http://php.net/manual/en/function.strip-tags.php
    @todo     -
    @version  3.0
     */

    public static function string_clean($string){
        if (is_array($string)){
            foreach ($string as $key => $val){
                $return[$key] = string_clean($val);
            }
        }else{
            $return = (string) $string;
            if (get_magic_quotes_gpc()){
                $return = stripslashes($return);
            }
            $return = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $return);
            $return = preg_replace('#<style(.*?)>(.*?)</style>#is', '', $return);
            $return = preg_replace('#<noscript>(.*?)</noscript>#is', '', $return);
            $return = strip_tags($return);
            $return = htmlentities($return, ENT_QUOTES, 'UTF-8');
        }
        return $return;
    }

    /**
    @abstract Returns what is between $start and $end in the given content $string
    @example  string_between('What is it','What','it')
    @param    string $string
    @param    string $start
    @param    string $end
    @return   string between
    @link     http://php.net/manual/en/function.strpos.php
    @todo     $r=explode($start,$string);if(isset($r[1])){$r=explode($end,$r[1]);return $r[0];}
    @version  1.0
     */

    public static function string_between($string, $start, $end){
        $string = ' '.$string;
        $ini = strpos($string,$start);
        if ($ini == 0) return false;
        $ini += strlen($start);
        $len = strpos($string,$end,$ini) - $ini;
        return substr($string,$ini,$len);
    }


    /**
     * Slugify UTF-8 Strings
     * @param $string
     * @return string|string[]|null
     */
    public static function createSlug($string)
    {
        $slug = null;
        if(\voku\helper\UTF8::is_ascii($string))
        {
            $slug    = \Illuminate\Support\Str::slug($string);
        }
        elseif (\voku\helper\UTF8::is_utf8($string))
        {
            $slug = preg_replace("/[\s-]+/", " ", $string);
            $slug = preg_replace("/[\s_]/", '-', $slug);
        }
        return $slug;
    }

    /**
     * Get setting from the database
     * @param $settingKey
     * @return mixed|null
     */
    public static function getSetting($settingKey)
    {
        $settingValue = \App\Models\Setting::where('setting_key',$settingKey)->value('setting_value');
        return ($settingValue ? $settingValue : null);
    }

    /**
     * Save Setting in DB
     * @param $settingKey
     * @param $settingValue
     * @param null $type
     * @return bool
     */
    public static function saveSetting($settingKey, $settingValue, $type=null)
    {
        if(!is_null($type))
        {
            $result = DB::table('site_settings')->where('setting_key','=',$settingKey)->update(['setting_value' => json_encode($settingValue)]);
        } else {
            $result = DB::table('site_settings')->where('setting_key','=',$settingKey)->update(['setting_value' => $settingValue]);
        }

        return true;
    }

    /**
     * Comma separated string to an array
     * @param $string
     * @return array
     */
    public static function stringToArray($string)
    {
        $array = array_map('trim', explode(',', $string));
        return $array;
    }

    /**
     * Get all settings from the settings table
     * @return array
     */

    public static function getAllSettings()
    {
        $data = array();
        $keys= DB::table('site_settings')->lists('setting_key');
        $total = DB::table('site_settings')->count();
        $values = DB::table('site_settings')->lists('setting_value');
        for($i=0; $i<$total; $i++) {
            $data[$keys[$i]] = $values[$i];
        }
        return $data;
    }



    public static function toAtomDate(string $dateTime, string $timezone= 'Asia/Calcutta')
    {
        try {
            $date = Carbon::createFromFormat('Y-m-d H:i:s', $dateTime)->setTimezone($timezone);
            return $date->toAtomString();
        } catch (\Exception $e) {
            Log::error('GeneralHelper - toAtomString : ' . $e->getMessage());
            return '';
        }
    }

    /**
     * Mark user status as online or offline
     */
    public static function markOnlineStatus($userID, $status) {
        try {
            $user = \App\User::findOrFail($userID);
            $user->online_status = $status;
            $user->save();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Get related posts
     */
    public static function getRelatedPosts(\App\Blog $blog) {
        try {
            $blogs = \App\Blog::where('category_id', $blog->category_id)->take(2)->get();
            $blogs = null;
            if($blogs == null) {
                $blogs = \App\Blog::where("title", "LIKE", "%" . $blog->title . "%")
                    ->orWhere("tags", "LIKE", "%" . $blog->tags . "%")
                    ->take(2)->get();
            }
            return $blogs;
        } catch (Exception $e) {
            return null;
        }
    }

    /*
     * Get reaction data
     */
    public static function getReactionData(\App\Blog $blog) {
        try {

        } catch (Exception $e) {

        }
    }

    public static function getSEODescription(\App\Blog $blog) {
        try {
            $posts = $blog->body;
            foreach ($posts as $key => $value) {
                if($value['type'] == 'paragraph') {
                    return $value['data']['text'];
                } else {
                    continue;
                }
            }
        } catch (Exception $e) {
            return null;
        }
    }

    public static function getSEOImage(\App\Blog $blog) {
        try {
            $posts = $blog->body;
            foreach ($posts as $key => $value) {
                if($value['type'] == 'image' || $value['type'] == 'search') {
                    return (isset($value['data']['url']) ? $value['data']['url'] : $value['data']['file']['url']);
                } else {
                    continue;
                }
            }
        } catch (Exception $e) {
            return null;
        }
    }

}
