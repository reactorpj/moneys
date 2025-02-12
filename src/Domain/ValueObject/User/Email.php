<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\User;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;
use Symfony\Component\Validator\Constraints as Assert;

#[Embeddable]
final readonly class Email
{
	#[Column(type: 'string', length: 255)]
	#[Assert\NotBlank()]
	private string $value;

	public function __construct(string $email)
	{
		$email = trim($email);
		if (!filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			throw new \InvalidArgumentException('Invalid email');
		}

		$this->value = $email;
	}

	public static function fromString(string $email): self
	{
		return new self($email);
	}

	public function getValue(): string
	{
		return $this->value;
	}
}