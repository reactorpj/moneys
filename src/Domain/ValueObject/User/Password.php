<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\User;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
final readonly class Password
{
	#[ORM\Column(type: 'string', length: 255, nullable: false)]
	private string $hash;

	public function __construct(string $password)
	{
		Assert::notEmpty($password);
		$this->hash = $password;
	}

	public static function fromString(string $password)
	{
		return new self($password);
	}

	public function getValue(): string
	{
		return $this->hash;
	}
}