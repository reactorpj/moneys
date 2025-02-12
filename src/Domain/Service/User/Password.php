<?php

declare(strict_types=1);

namespace App\Domain\Service\User;

class Password
{
	public function hash(string $password): string
	{
		return password_hash($password, PASSWORD_DEFAULT);
	}
}