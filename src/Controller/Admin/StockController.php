<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\ProductType;
use App\Form\StockType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StockController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @return Response
     */
    #[Route('/admin/stock', name: 'admin.products.stock')]
    public function stocks(ManagerRegistry $repo): Response
    {
        $products = $repo->getRepository(Product::class)->findAll();
        return $this->render('admin/stock/stocks.html.twig', [
            'products'          => $products
        ]);
    }

    /**
     * @param Product $product
     * @param Request $request
     * @return Response
     */
    #[Route('/admin/stock/{id}', name: 'admin.product.compute')]
    public function take(Product $product, Request $request): Response
    {
        $defal = $product->getStockReel();
        $form = $this->createForm(StockType::class, $product);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $preleve = $form->getData()->getPreleve();
            $resul = $defal - $preleve;
            $product->setStockReel($resul);
            $this->em->flush();
            $this->addFlash('success', 'Vous Avez bien défalqué le Lot En questions');
            return $this->redirectToRoute('admin.products.stock');
        }
        return $this->render('admin/stock/compute.html.twig', [
            'product'       =>$product,
            'form'      => $form->createView()
        ]);
    }
}
