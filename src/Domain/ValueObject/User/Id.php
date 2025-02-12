<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\User;

use Ramsey\Uuid\Uuid;

final readonly class Id
{
	/**
	 * @param string $uuid
	 */
	private function __construct(private string $uuid) { }

	/**
	 * @return Id
	 */
	public static function next(): Id
	{
		return new self(Uuid::uuid4()->toString());
	}

	/**
	 * @param string $value
	 * @return Id
	 */
	public static function fromString(string $value): Id
	{
		return new self($value);
	}

	/**
	 * @return string
	 */
	public function getValue(): string
	{
		return $this->uuid;
	}
}