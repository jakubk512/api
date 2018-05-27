<?php
/**
 * Created by PhpStorm.
 * User: jakub.krejszeff@g2a.local
 * Date: 27.05.18
 * Time: 22:14
 */

namespace AppBundle\Utils\ProductCatalog;


class RequestValidator
{
    public static function isValidId($id){
        return !empty($id) && is_int($id);
    }

    public static function isValidTitle($title){
        return !empty($title) && is_string($title);
    }

    public static function isValidPrice($price){
        return !empty($price) && is_double($price);
    }

}