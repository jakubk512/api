<?php
/**
 * Created by PhpStorm.
 * User: jakub.krejszeff@g2a.local
 * Date: 24.06.18
 * Time: 23:55
 */

namespace AppBundle\Exception;


class InvalidDataException extends \Exception
{
    const INVALID_ID_PASSED = 'Passed invalid id!';
    const PASSED_INVALID_PARAMETERS = 'Passed invalid parameters!';
}