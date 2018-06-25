<?php
/**
 * Created by PhpStorm.
 * User: jakub.krejszeff@g2a.local
 * Date: 25.06.18
 * Time: 03:41
 */

namespace AppBundle\Utils\Cart;


class CartHelper
{
    /**
     * @param $mappedCartItems
     * @return float
     */
    public static function getTotalPrice($mappedCartItems)
    {
        $totalPrice = 0;

        foreach ($mappedCartItems as $val) {
            $totalPrice += $val['price'];
        }
        return $totalPrice;
    }
}