<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\User\Type;

use App\Domain\ValueObject\User\Email;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use Doctrine\DBAL\Types\Types;

class EmailType extends StringType
{
	public const NAME = 'user_user_email';

	public function convertToDatabaseValue($value, AbstractPlatform $platform)
	{
		if (!$value instanceof Email)
		{
			return $value;
		}

		return mb_strtolower($value->getValue());
	}

	public function convertToPHPValue($value, AbstractPlatform $platform)
	{
		return Email::fromString($value);
	}

	public function getName(): string
	{
		return self::NAME;
	}

	public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
	{
		return $platform->getStringTypeDeclarationSQL($column);
	}


	public function requiresSQLCommentHint(AbstractPlatform $platform): bool
	{
		return true;
	}
}