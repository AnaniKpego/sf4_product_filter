<?php
/**
 * Created by PhpStorm.
 * User: PKDTECHNOLOGIESINC-K
 * Date: 13/12/2019
 * Time: 13:55
 */

namespace App\Controller\Admin;


use App\Data\SearchData;
use App\Entity\Product;
use App\Form\ProductType;
use App\Form\SearchForm;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AdminController extends AbstractController
{
    /**
     * @var ProductRepository
     */
    private $repository;
    /**
     * @property EntityManagerInterface em
     */

    private $em;

    public function __construct(ProductRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;

    }


    /**
     * @Route("/admin/products", name="product.admin.index")
     * @param Request $request
     * @return Response
     */
    public function adminIndex(Request $request){

        $data = new SearchData();
        $data->page = $request->get('page', 1);
        $form = $this->createForm(SearchForm::class, $data);
        $form->handleRequest($request);
        //dd($data);
        [$min, $max] = $this->repository->findMinMax($data);
        $products = $this->repository->findBySearch($data);
        $countProd = $this->repository->findAll();
        $totalProd = count($countProd);
        return $this->render('admin/index.html.twig', [
            'products'=>$products,
            'form'=>$form->createView(),
            'min' => $min,
            'max'=>$max,
            'totalProd'=>$totalProd
        ]);
    }


    /**
     * @Route("/admin/product/create", name="product.admin.create")
     * @param Request $request
     * @return Response
     */
    public function newProduct(Request $request){

        $products = new Product();
        $form = $this->createForm(ProductType::class, $products);
        $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid()){
            $this->em->persist($products);
            $this->em->flush();
            $this->redirectToRoute('product.admin.index');
        }
        return $this->render('admin/create.html.twig',[
            'form'=>$form->createView(),
            'products'=>$products
        ]);

    }

    /**
     * @Route("/admin/product/edit/{id}", name="product.admin.edit", methods="GET|POST")
     * @param Product $product
     * @return Response
     * @param Request $request
     */
    public function edit(Product $product, Request $request):Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $this->em->flush();
            return $this->redirectToRoute('product.admin.index');
        }
        return $this->render('admin/edit.html.twig',[
        'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/admin/product/delete/{id}", name="product.admin.delete",  methods="DELETE")
     * @param Product $product
     * @param Request $request
     * @return Response
     */
    public function delete(Product $product, Request $request):Response
    {
        $getId = $product->getId();
        $getToken = $request->get('_token');

        if ($this->isCsrfTokenValid('delete'. $getId, $getToken)){

            $this->em->remove($product);
            $this->em->flush();

        }

       return $this->redirectToRoute('product.admin.index');

    }

}