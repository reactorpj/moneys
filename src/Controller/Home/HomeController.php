<?php

namespace App\Controller\Home;

use App\Form\Account\NewAccountType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(Request $request): Response
    {
		$form = $this->createForm(NewAccountType::class);
		$form->handleRequest($request);

        return $this->render('home/home.html.twig', [
			'form' => $form->createView(),
        ]);
    }
}
