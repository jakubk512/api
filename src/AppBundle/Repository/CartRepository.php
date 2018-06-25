<?php
namespace AppBundle\Repository;

use AppBundle\Entity\Cart;
use AppBundle\Utils\Cart\CartHelper;
use AppBundle\Utils\ProductCatalog\RequestValidator;
use AppBundle\Exception\InvalidDataException;

class CartRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param $userId
     * @return array
     * @throws \Exception
     */
    public function getAllProducts($userId){
       $mappedCartItems = [];

       $cartItems = $this->createQueryBuilder('e')
           ->select('e')
           ->where('e.userId = '.$userId)
           ->getQuery()
           ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);


       foreach ($cartItems as $val){
           $mappedCartItems += array_merge($mappedCartItems,$this->getEntityManager()
                ->getRepository('AppBundle:ProductCatalog')
                ->getProductById($val['productId']));
       }

        $mappedCartItems['total_price'] = CartHelper::getTotalPrice($mappedCartItems);

        return $mappedCartItems;
    }

    /**
     * @param $userId
     * @return int
     * @throws \Exception
     */
    public function getProductsQuantity($userId){
       return !empty($this->getAllProducts($userId)) ? count($this->getAllProducts($userId)) : 0;
    }

    /**
     * @param $productId
     * @param $userId
     * @throws InvalidDataException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deleteProduct($productId,$userId){

        if(!RequestValidator::isValidId($productId) || !RequestValidator::isValidId($userId)){
            throw new InvalidDataException(InvalidDataException::INVALID_ID_PASSED);
        }

       $em = $this->getEntityManager();
       $product = $this->findOneBy(
           [
               'productId' => $productId,
               'userId'    => $userId
           ]
       );

       if(empty($product)){
           throw new \Exception('Product dont exists');
       }

       $em->remove($product);
       $em->flush();
    }

    /**
     * @param $productId
     * @param $userId
     * @throws InvalidDataException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addProduct($productId,$userId){
        if(!RequestValidator::isValidId($productId) || !RequestValidator::isValidId($userId)){
            throw new InvalidDataException(InvalidDataException::INVALID_ID_PASSED);
        }

        $product = new Cart();
        $product->setProductId($productId);
        $product->setUserId($userId);

        $em = $this->getEntityManager();
        $em->persist($product);
        $em->flush();
    }

}