<?php
/**
 * Created by PhpStorm.
 * User: PKDTECHNOLOGIESINC-K
 * Date: 20/12/2019
 * Time: 16:23
 */

namespace App\Controller;


use App\Service\Cart\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @var CartService
     */
    private $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * @Route("/cart", name="cart_index")
     * @return Response
     */
    public function index()
    {
       $cartWithData = $this->cartService->getFullCart();
       $total = $this->cartService->getTotal();

       return $this->render('cart/index.html.twig',[
          'items'=>$cartWithData,
           'total'=>$total

       ]);

    }

    // Ajout de produits au cart
    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/cart/add/{id}", name="cart_add")
     */
    public function add($id)
    {
        $this->cartService->add($id);
        return $this->redirectToRoute("cart_index");
        //dd($session->get('cart'));
    }

    //Supprimer tous le contenu d'un article du cart
    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/cart/remove/{id}", name="cart_remove")
     */
    public function remove($id)
    {
        $this->cartService->remove($id);
        return $this->redirectToRoute("cart_index");
    }

    //Supprimer du contenu un par un
    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/cart/removeOne/{id}", name="cart_removeOne")
     */
    public function removeOneByOne( $id){

        $this->cartService->removeOneByOne($id);
        return $this->redirectToRoute("cart_index");
    }

}