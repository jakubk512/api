<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Utils\Exception\ExceptionHelper;

class ProductCatalogController extends FOSRestController
{

    /**
     * Parameters: string title, double price
     * @Method({"POST"})
     * @Route("/productcatalog",name="post")
     * Response(
     *   response="200",
     *   description="Product added"
     * )
     * Response(
     *   response="500",
     *   description="An error occured"
     * )
     */
    public function postAction(Request $request)
    {
        try{
            $productCatalogRepo = $this->get('product_catalog_repository');
            $productCatalogRepo->addProduct($request->get('title'),(double) $request->get('price'));
            return new JsonResponse(['status' => true],200);
        }catch(\Exception $e){
            return ExceptionHelper::handleException($e);
        }
    }

    /**
     * Parameters: int productId, string title, double price
     * @Method({"PUT"})
     * @Route("/productcatalog",name="put")
     * Response(
     *   response="200",
     *   description="Product updated"
     * )
     * Response(
     *   response="500",
     *   description="An error occured"
     * )
     */
    public function putAction(Request $request)
    {
        try{
            $productCatalogRepo = $this->get('product_catalog_repository');
            $productCatalogRepo->updateProduct(
                (int) $request->headers->get('productId'),
                $request->headers->get('title'),
                (double) $request->headers->get('price')
            );

            return new JsonResponse(['status' => true],200);
        }catch(\Exception $e){
            return ExceptionHelper::handleException($e);
        }
    }

    /**
     * Parameters: int productId
     * @Method({"DELETE"})
     * @Route("/productcatalog", name="delete")
     * Response(
     *   response="200",
     *   description="Product deleted"
     * )
     * Response(
     *   response="500",
     *   description="An error occured"
     * )
     */
    public function deleteAction($productId)
    {
        try{
            $productCatalogRepo = $this->get('product_catalog_repository');
            $productCatalogRepo->deleteProduct($productId);

            return new JsonResponse(['status' => true]);

        }catch (\Exception $e){
            return ExceptionHelper::handleException($e);
        }
    }


    /**
     * @Method({"GET"})
     * @Route("/productcatalog",name="get")
     * Response(
     *   response="200",
     *   description="Products fetched"
     * )
     * Response(
     *   response="500",
     *   description="An error occured"
     * )
     */
    public function getAction()
    {
        try{
            $productCatalogRepo = $this->get('product_catalog_repository');
            $products = $productCatalogRepo->getAllProducts();

            if(empty($products)){
                throw new \Exception('There isn\'t any products in product catalog!');
            }

            return new JsonResponse($products,200);
        }catch (\Exception $e){
            return ExceptionHelper::handleException($e);
        }

    }

}