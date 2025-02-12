<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\User\User;

interface UserRepository
{
	public function save(User $user): void;
}