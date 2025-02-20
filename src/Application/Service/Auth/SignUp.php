<?php

namespace App\Application\Service\Auth;

use App\Application\Dto\Auth\SignUpDto;
use App\Domain\Entity\User\User;
use App\Domain\Service\User\Password as PasswordService;
use App\Domain\ValueObject\User\Email;
use App\Domain\ValueObject\User\Id;
use App\Domain\ValueObject\User\Password;
use App\Infrastructure\Repository\UserRepository;

readonly class SignUp
{
	public function __construct(
		private PasswordService $passwordService,
		private UserRepository $userRepository,
	) { }

	public function request(SignUpDto $dto): User
	{
		$user = User::createForUser(
			id: Id::next(),
			email: Email::fromString($dto->email),
			password: Password::fromString($this->passwordService->hash($dto->password)),
		);

		$this->userRepository->save($user);

		return $user;
	}
}