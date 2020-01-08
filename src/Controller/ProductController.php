<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Form\SearchForm;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/", name="product")
     */
    public function index(ProductRepository $productRepository, Request $request)
    {
        $data = new SearchData();
        $data->page = $request->get('page', 1);
        $form = $this->createForm(SearchForm::class, $data);
        $form->handleRequest($request);
        //dd($data);
        [$min, $max] = $productRepository->findMinMax($data);
        $products = $productRepository->findBySearch($data);
        return $this->render('product/index.html.twig', [
            'products'=>$products,
            'form'=>$form->createView(),
            'min' => $min,
            'max'=>$max
        ]);
    }

}
