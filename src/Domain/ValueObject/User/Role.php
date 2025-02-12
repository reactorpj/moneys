<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\User;

use App\Domain\Type\UserRole;

final readonly class Role
{
	private array $roles;

	/**
	 * @param UserRole[] $roles
	 */
	public function __construct(array $roles)
	{
		$this->roles = array_unique(array_filter($roles, fn($role) => $role instanceof UserRole));
	}

	/**
	 * @param UserRole[] $roles
	 * @return self
	 */
	public static function fromArray(array $roles): self
	{
		return new self($roles);
	}

	public function getValue(): array
	{
		return $this->roles;
	}
}