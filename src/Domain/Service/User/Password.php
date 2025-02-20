<?php

declare(strict_types=1);

namespace App\Domain\Service\User;

class Password
{
	public function hash(string $password): string
	{
		return password_hash($password, PASSWORD_DEFAULT);
	}

	public function validate(string $password, string $hash): bool
	{
		return password_verify($password, $hash);
	}
}