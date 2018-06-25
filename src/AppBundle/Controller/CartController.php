<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Utils\Exception\ExceptionHelper;

class CartController extends FOSRestController
{

    /**
     * Parameters: int product id, int user id
     * @Method({"POST"})
     * @Route("/cart",name="cart_post")
     * Response(
     *   response="200",
     *   description="Product added to cart"
     * )
     * Response(
     *   response="500",
     *   description="An error occured"
     * )
     */
    public function postAction(Request $request)
    {
        try{
            $cartRepo = $this->get('cart_repository');
            $productCatalogRepo = $this->get('product_catalog_repository');
            $userId = (int) $request->get('userId');
            $productId = (int) $request->get('productId');

            if(empty($productCatalogRepo->getProductById($productId))){
                throw new \Exception('Product that you are trying to add don\'t exists in product catalog!');
            }
            if($cartRepo->getProductsQuantity($userId) > 3){
                throw new \Exception('You can\'t add more than 3 products to cart.');
            }

            $cartRepo->addProduct($productId, $userId);
            return new JsonResponse(['status' => true],200);
        }catch(\Exception $e){
            return ExceptionHelper::handleException($e);
        }
    }

    /**
     * Parameters: int productId, int user id
     * @Method({"DELETE"})
     * @Route("/cart/{productId}/{userId}", name="cart_delete")
     * Response(
     *   response="200",
     *   description="Product deleted"
     * )
     * Response(
     *   response="500",
     *   description="An error occured"
     * )
     */
    public function deleteAction($productId,$userId)
    {
        try{
            $cartRepo = $this->get('cart_repository');
            $cartRepo->deleteProduct((int) $productId,(int) $userId);

            return new JsonResponse(['status' => true]);

        }catch (\Exception $e){
            return ExceptionHelper::handleException($e);
        }
    }


    /**
     * Parameters: int user id
     * @Method({"GET"})
     * @Route("/cart/{userId}",name="cart_get")
     * Response(
     *   response="200",
     *   description="Products fetched"
     * )
     * Response(
     *   response="500",
     *   description="An error occured"
     * )
     */
    public function getAction($userId)
    {
        try{
            $cartRepo = $this->get('cart_repository');
            $products = $cartRepo->getAllProducts($userId);
            if(empty($products)){
                throw new \Exception('There isn\'t any products in a cart!');
            }
            return new JsonResponse($products,200);
        }catch (\Exception $e){
            return ExceptionHelper::handleException($e);
        }

    }
}
