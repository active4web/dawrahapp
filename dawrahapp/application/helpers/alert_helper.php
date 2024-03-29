<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');



if (!function_exists('message_box')) {

    function message_box($message_type, $close_button = TRUE)
    {
        $CI = &get_instance();
        $message = $CI->session->flashdata($message_type);
        $retval = '';

        if ($message) {
            switch ($message_type) {
                case 'success':
                    $retval = '<script type="text/JavaScript">$(document).ready(function () {'
                        . 'toastr.success("' . $message . '"); });</script>';
                    break;
                case 'error':
                    $retval = '<script type="text/JavaScript">$(document).ready(function () {'
                        . 'toastr.error("' . $message . '");});</script>';
                    break;
                case 'info':
                    $retval = '<script type="text/JavaScript">$(document).ready(function () {'
                        . 'toastr.info("' . $message . '");});</script>';
                    break;
                case 'warning':
                    $retval = '<script type="text/JavaScript">$(document).ready(function () {'
                        . 'toastr.warning("' . $message . '");});</script>';
                    break;
            }
            return $retval;
        }
    }

}

if (!function_exists('set_message')) {

    function set_message($type, $message)
    {
        $CI = &get_instance();
        $CI->session->set_flashdata($type, $message);
    }

}


if(!function_exists('message_error'))
{
    function message_error($message)
    {
          $output = '<div class="alert alert-danger alert-dismissable">
                <i class="fa fa-ban"></i>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                '.$message.'
              </div>';
          return $output;
    }

}


if(!function_exists('message_done'))
{
    function message_done($message)
    {
          $output = '<div class="alert alert-success alert-dismissable">
                <i class="fa fa-ban"></i>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                '.$message.'
              </div>';
          return $output;
    }

}
