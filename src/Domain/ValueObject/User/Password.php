<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\User;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
final readonly class Password
{
	#[ORM\Column(name: 'password_hash', type: 'string', length: 255, nullable: false)]
	private string $passwordHash;

	public function __construct(string $password)
	{
		Assert::notEmpty($password);
		$this->passwordHash = $password;
	}

	public static function fromString(string $password): Password
	{
		return new self($password);
	}

	public function getValue(): string
	{
		return $this->passwordHash;
	}
}