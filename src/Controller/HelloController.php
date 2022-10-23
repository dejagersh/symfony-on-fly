<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    #[Route('/')]
    public function index(ManagerRegistry $doctrine)
    {
        $entityManager = $doctrine->getManager();

        $product = new Product();
        $product->setName('Hello');
        $product->setPrice(50);

        $entityManager->persist($product);

        $entityManager->flush();

        return new Response('Hello, world!');
    }
}