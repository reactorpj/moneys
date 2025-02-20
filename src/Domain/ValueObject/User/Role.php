<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\User;

final readonly class Role
{
	public const ROLE_USER = 'ROLE_USER';
	public const ROLE_ADMIN = 'ROLE_ADMIN';
	private array $roles;

	/**
	 * @param string[] $roles
	 */
	public function __construct(array $roles)
	{
		$this->roles = array_unique($roles);
	}

	/**
	 * @param string[] $roles
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