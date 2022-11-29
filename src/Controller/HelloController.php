<?php

namespace App\Controller;

use App\Entity\Product;
use App\Message\SendEmailMessage;
use App\Repository\ProductRepository;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Transport\TransportInterface;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    #[Route('/')]
    public function index(ProductRepository $productRepository, LoggerInterface $logger)
    {
        $products = $productRepository->findAll();

        return $this->render('hello.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/products', methods: ['POST'])]
    public function saveProduct(Request $request, ManagerRegistry $doctrine)
    {
        $entityManager = $doctrine->getManager();

        $product = new Product();
        $product->setName($request->get('name'));
        $product->setPrice((int)$request->get('price'));
        $entityManager->persist($product);
        $entityManager->flush();

        return $this->redirect('/');
    }

    #[Route('/dispatch-message', methods: ['POST'])]
    public function dispatchMessage(MessageBusInterface $messageBus)
    {
        $messageBus->dispatch(new SendEmailMessage('Johannes'));

        return $this->redirect('/');
    }
}
