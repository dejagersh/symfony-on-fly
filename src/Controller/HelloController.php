<?php

namespace App\Controller;

use App\Entity\Product;
use App\Message\SendEmailMessage;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Transport\TransportInterface;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    #[Route('/')]
    public function index(LoggerInterface $logger, ManagerRegistry $doctrine, MessageBusInterface $messageBus)
    {
        $logger->error('Hello, world');

        $messageBus->dispatch(new SendEmailMessage('Johannes'));

        $entityManager = $doctrine->getManager();

        $product = new Product();
        $product->setName('Hello');
        $product->setPrice(50);

        $entityManager->persist($product);

        $entityManager->flush();

        return new Response('Hello, world!');
    }
}