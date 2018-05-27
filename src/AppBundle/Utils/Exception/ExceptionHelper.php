<?php
/**
 * Created by PhpStorm.
 * User: jakub.krejszeff@g2a.local
 * Date: 27.05.18
 * Time: 22:37
 */

namespace AppBundle\Utils\Exception;


use Symfony\Component\HttpFoundation\JsonResponse;

class ExceptionHelper
{
    /**
     * @param \Exception $e
     * @return JsonResponse
     */
    public static function handleException(\Exception $e){
        return new JsonResponse(['error_message' => $e->getMessage()],500);
    }
}