<?php

declare(strict_types=1);

namespace App\Application\Controller\Auth;

use App\Application\Controller\ErrorHandler;
use App\Application\Dto\Auth\SignUpDto;
use App\Application\Service\Auth\SignUp;
use App\Domain\Exception\Auth\SignUpException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SignUpController extends AbstractController
{
	public function __construct(
		private readonly ErrorHandler $errorHandler,
		private Security $security,
	)
	{
	}

	#[Route(path: '/signup', name: 'signup', methods: ['POST', 'GET'])]
	public function request(Request $request, SignUp $service): Response
	{
		$dto = new SignUpDto();
		$form = $this->createForm(\App\Domain\Form\User\SignUp::class, $dto);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid())
		{
			try
			{
				$user = $service->request($dto);

				$response = $this->security->login($user);

				return $this->redirectToRoute('home');
			} catch (SignUpException $exception)
			{
				$this->errorHandler->handle($exception);
				$this->addFlash('error', $exception->getMessage());
			}
		}

		return $this->render('signup/signup.html.twig', [
			'form' => $form->createView(),
		]);
	}
}
