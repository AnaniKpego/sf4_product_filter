<?php
/**
 * Created by PhpStorm.
 * User: PKDTECHNOLOGIESINC-K
 * Date: 20/12/2019
 * Time: 16:33
 */

namespace App\Service\Cart;


use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{

    protected $session;

    protected $productRepository;

    public function __construct(SessionInterface $session, ProductRepository $productRepository)
    {
        $this->session = $session;
        $this->productRepository = $productRepository;
    }

    //Add an article in the car

    public function add(int $id)
    {
        $cart = $this->session->get('cart', []);

        if (!empty($cart[$id])){
            $cart[$id]++;
        }else{
            $cart[$id] = 1;
        }

        $this->session->set('cart', $cart);
    }

    //Remove some product to the cart

    public function removeOneByOne(int  $id){

        $cart = $this->session->get('cart', []);

        if (!empty($cart[$id])){
            $cart[$id]--;
        }
        $this->session->set('cart', $cart);
    }

    // Remove all quantity of one article to the cart
    public function remove(int $id)
    {
        $cart = $this->session->get('cart',[]);
        if (!empty($cart[$id])){
            unset($cart[$id]);
        }
        $this->session->set('cart',$cart);
    }

    public function getFullCart():array
    {
        $cart = $this->session->get('cart',[]);

        $cartWithData = [];
        foreach ($cart as $id => $quantity){
            $cartWithData[] = [
                'product' => $this->productRepository->find($id) ,
                'quantity'=> $quantity
            ];
        }
        return $cartWithData;

    }

    public function getTotal():float
    {
        $total = 0;
        foreach ($this->getFullCart() as $item){
            $total += $item['product']->getPrice()*$item['quantity'];
        }
        return $total;
    }

}