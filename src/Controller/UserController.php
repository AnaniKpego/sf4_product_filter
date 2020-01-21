<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends AbstractController
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var EntityManagerInterface registry
     */
    private $registry;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $registry)
    {
        $this->userRepository = $userRepository;
        $this->registry = $registry;
    }

    /**
     * @Route("/admin/user", name="user")
     */
    public function index()
    {

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/admin/user/new", name="user-create")
     * @param Request $request
     */
    public function create(Request $request)
    {
        $users = new User();
        $form = $this->createForm(UserType::class, $users);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->registry->persist($users);
            $this->registry->flush();
            $this->redirectToRoute('user');
        }
        return $this->render('admin/users/create.html.twig',[
            'form'=>$form->createView(),
            'users'=>$users
        ]);

    }

}
