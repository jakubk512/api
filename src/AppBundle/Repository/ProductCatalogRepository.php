<?php
namespace AppBundle\Repository;

use AppBundle\Entity\ProductCatalog;
use AppBundle\Utils\ProductCatalog\RequestValidator;
use Symfony\Component\Config\Tests\Util\Validator;

class ProductCatalogRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @return array
     */
    public function getAllProducts(){
       return $this->createQueryBuilder('e')
           ->select('e')
           ->getQuery()
           ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

    public function getProductById($productId){
       return $this->createQueryBuilder('e')
            ->select('e')
            ->where('e.id = '.$productId)
            ->getQuery()
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

    /**
     * @param $id
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     */
    public function deleteProduct($id){

        if(!RequestValidator::isValidId($id)){
            throw new \Exception('Invalid id!');
        }

       $em = $this->getEntityManager();
       $product = $this->findOneBy(['id' => $id]);

       if(empty($product)){
           throw new \Exception('Product dont exists');
       }

       $em->remove($product);
       $em->flush();
    }

    /**
     * @param $title
     * @param $price
     * @throws \Exception
     */
    public function addProduct($title,$price){
        if(!RequestValidator::isValidTitle($title) || !RequestValidator::isValidPrice($price)){
            throw new \Exception('Invalid parameters passed!');
        }

        $product = new ProductCatalog();
        $product->setTitle($title);
        $product->setPrice($price);

        $em = $this->getEntityManager();
        $em->persist($product);
        $em->flush();
    }

    /**
     * @param $title
     * @param $price
     * @throws \Exception
     */
    public function updateProduct($id,$title,$price){
        if(
            !RequestValidator::isValidId($id)
        ){
            throw new \Exception('Invalid id passed!');
        }

        $product = $this->findOneBy(['id' => $id]);

        $product->setTitle($title);
        $product->setPrice($price);

        $em = $this->getEntityManager();
        $em->persist($product);
        $em->flush();
    }
}