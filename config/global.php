<?php

/**
 * Global Configuration file for the application
 *
 */

return array(

    'image_resize' => array(
        'category_imageX'                       => 1200,
        'category_imageY'                       => 800
    ),

    'campaign' => array(
        'default_avatar'                        => '/images/campaign/original/default.png',
        'upload_folder_path'                    => '/images/campaign/',
        'upload_folder_path_original'           => '/images/campaign/original/',
        'upload_folder_path_resized'            => '/images/campaign/resized/',
        'upload_folder_seo_path_original'       => '/images/campaign/original/',
        'upload_folder_seo_path_resized'        => '/images/campaign/resized/',
    ),
    'contacts' => array(
        'upload_folder_path'                    => '/uploads/contacts/',
        'upload_folder_path_original'           => '/uploads/contacts/original/',
        'upload_folder_path_resized'            => '/uploads/contacts/resized/'
    ),
    'user' => array(
        'default_avatar'                        => '/images/user/original/default.png',
        'upload_folder_path'                    => '/images/user/',
        'upload_folder_path_original'           => '/images/user/original/',
        'upload_folder_path_resized'            => '/images/user/resized/',
    ),

    'twilio' => array(
        'sandbox_number'                        => '+14155238886',
        'WA_NUMBER'                             => '+19284400489',
        'sandbox_message'                       => 'join pain-dinner',
        'TWILIO_SID'                            => 'AC41ce78f1fd50aecc64240d3d640c7432',
        'TWILIO_AUTH_TOKEN'                     => '128fb399d716799c7fd584a5d9f1bc49'
    ),

);
