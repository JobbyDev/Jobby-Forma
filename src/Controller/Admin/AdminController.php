<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @return Response
     */
    #[Route('/admin', name: 'admin.index')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'mainNavAdmin'      => true,
        ]);
    }

    /**
     * @return Response
     */
    #[Route('/admin/products', name: 'admin.products')]
    public function products(ManagerRegistry $repo): Response
    {
        $products = $repo->getRepository(Product::class)->findAll();
        return $this->render('admin/produit/products.html.twig', [
            'products'          => $products
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    #[Route('/admin/new', name: 'admin.product.new')]
    public function new(Request $request): Response
    {
        $product= new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush();
            $this->addFlash('succes', 'L\'Article a bien été créé avec succès');
            return $this->redirectToRoute("admin.products");
        }

        return $this->render('admin/produit/productNew.html.twig', [
            'product'          => $product,
            'form'              => $form->createView()
        ]);
    }

    /**
     * @param Product $product
     * @param Request $request
     * @return Response
     */
    #[Route('/admin/product/edit/{id}', name: 'admin.product.edit', methods: 'GET|POST')]
    public function edit(Product $product, Request $request): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush();
            $this->addFlash('success', 'Le produit a été modifié avec succès');
            return $this->redirectToRoute('admin.products');
        }
        return $this->render('admin/produit/productEdit.html.twig', [
            'product'          => $product,
            'form'              => $form->createView()
        ]);
    }

    /**
     * @param Product $product
     * @param Request $request
     * @return Response
     */
    #[Route('/admin/product/delete/{id}', name: 'admin.product.delete')]
    public function delete(Product $product, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete' . $product->getId(), $request->get('_token'))) {
            $this->em->remove($product);
            $this->em->flush();
            $this->addFlash('success', 'Le produit a bien été supprimé avec succès');
        }
        return $this->redirectToRoute('admin.products');
    }
}
