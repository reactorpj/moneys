<?php

declare(strict_types=1);

namespace App\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
	#[Route(path: '/', name: 'home', methods: ['GET'])]
	public function index(): Response
	{
		return $this->render('home/home.html.twig');
	}
}
