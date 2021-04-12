<?php


class ImageHelper
{
    /*
        @abstract Download URL to local File usinf cURL
        @example  image_url2file('http://hinode.nao.ac.jp/latest/xrt_ffi_latest.gif', './test/sun.gif')
        @param    string $url
        @param    string $file
        @return   bool
        @link     http://hinode.nao.ac.jp/latest/xrt_ffi_latest.gif
        @todo     -
        @version  1.0
        */

    public static function image_url2file($url, $file){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
        $rawdata=curl_exec($ch);
        curl_close ($ch);
        if($fp = fopen("$file",'w')){
            fwrite($fp, $rawdata);
            fclose($fp);
            return true;
        }
        return false;
    }

    /*
	@abstract Extract Youtube Previewimage from given Youtube Video Link
	@example  image_youtube('https://www.youtube.com/watch?v=0pXYp72dwl0','a')
	@param    string $youtube_link
	@param    string $type [a or img default=a]
	@return   string HTML anker or image Tag
	@link     https://www.youtube.com/watch?v=j3qnXFN6Or8
	@todo     Optional: Save Image Local?
	@version  2.0
    */
    public static function image_youtube($youtube_link,$type='a'){
        $youtube_page = ' '.file_get_contents($youtube_link);
        $ini = strpos($youtube_page,'itemprop="thumbnailUrl" href="');
        $ini += strlen('itemprop="thumbnailUrl" href="');
        $len = strpos($youtube_page,'">',$ini) - $ini;
        $thumb = substr($youtube_page,$ini,$len);
        $return = "<img src=\"$thumb\" />";
        if($type=='a')$return = "<a href=\"$thumb\">Screenshot</a>";
        return $return;
    }

    /*
	@abstract Generate thumb from given image
	@example  image_thumb('./test/sun.gif',100,'./test/')
	@param    string $image Path an Image Filname
	@param    int $newwidth size of the thumb
	@param    string $target path to thump
	@return   string|bool Path to thump (name prefix 'tn_') or false on error
	@link     http://php.net/manual/en/function.imagecopyresampled.php
	@todo     -
	@version  1.0
    */
    public static function image_thumb($image, $newwidth, $target){
        if(!file_exists($image)) return false; // File not found
        $data     = getimagesize ($image);
        $width     = $data[0];
        $height    = $data[1];
        $typ       = $data[2];
        $newheight = intval($height*$newwidth/$width);
        $thumb     = $target.'tn_'.basename($image);
        switch ($typ){
            case '1':
                $old = imagecreatefromgif($image);
                $new = imagecreatetruecolor($newwidth,$newheight);
                imagecopyresampled($new,$old,0,0,0,0,$newwidth,$newheight,$width,$height);
                imagegif($new,$thumb);
                break;
            case '2':
                $old = imagecreatefromjpeg($image);
                $new = imagecreatetruecolor($newwidth,$newheight);
                imagecopyresampled($new,$old,0,0,0,0,$newwidth,$newheight,$width,$height);
                imagejpeg($new,$thumb);
                break;
            case '3':
                $old = imagecreatefrompng($image);
                $new = imagecreatetruecolor($newwidth,$newheight);
                imagecopyresampled($new,$old,0,0,0,0,$newwidth,$newheight,$width,$height);
                imagepng($new,$thumb);
                break;
            default:
                echo false; // Filetype not allowed!
        }
        return $thumb;
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

    /**Remove a file
     * @param $dir
     * @return bool
     */

    public static function rmdir_r($dir) {
        $files = array_diff(scandir($dir), array('.','..'));

        foreach ($files as $file) {
            if (is_dir("$dir/$file")) {
                rmdir_r("$dir/$file");
            } else {
                unlink("$dir/$file");
            }
        }
        return rmdir($dir);
    }

    /**Get Image type
     * @param $filename
     * @return string
     */
    public static function getImageType($filename) {
        $info = getimagesize($filename);
        $type = $info[2];

        if ($type == IMAGETYPE_JPEG) {
            $type = 'jpeg';
        } elseif ($type == IMAGETYPE_GIF) {
            $type = 'gif';
        } elseif ($type == IMAGETYPE_PNG) {
            $type = 'png';
        }

        return $type;
    }


    /**
     * Upload Image
     * Returns file name
     * @param $file
     * @param string $id
     * @param string $originalPath
     * @param string $resizedPath
     * @param string $dX
     * @param string $dY
     * @param null $filename_picture
     * @return string|null
     */
    public static function uploadImage($file, $id='', $originalPath='', $resizedPath='', $dX='256', $dY='256', $filename_picture=null)
    {
        $background = Image::canvas($dX, $dY);
        //$file_resize = $request->file('picture');
        $destinationpath_profile_original = $originalPath;
        $destinationpath_profile_resized = $resizedPath; //Resized
        $sampleextension_picture = $file->getClientOriginalExtension();
        if(is_null($filename_picture))
        {
            $filename_picture = $id.\GeneralHelper::string_rand(10) . $file->getClientOriginalName();
        }
        $upload_success_original = $file->move($destinationpath_profile_original, $filename_picture);
        $resize_file = $destinationpath_profile_original . $filename_picture;
        //dd($filename_picture);
        $resized = Image::make($resize_file)->resize($dX, $dY, function ($c) {
            $c->aspectRatio();
            $c->upsize();
        });
        $upload_success_resized = $background->insert($resized, 'center')->save($destinationpath_profile_resized . $filename_picture);
        if ($upload_success_original && $upload_success_resized) {
            $picture = $filename_picture;
            return $picture;
        } else {
            return null;
        }
    }

}
