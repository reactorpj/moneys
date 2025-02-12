<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\User\Type;

use App\Domain\ValueObject\User\Id;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use Doctrine\DBAL\Types\Types;
use Webmozart\Assert\Assert;

class IdType extends GuidType
{
	public const NAME = 'user_user_id';

	public function convertToDatabaseValue($value, AbstractPlatform $platform)
	{
		Assert::notEmpty($value);
		if (!$value instanceof Id)
		{
			return $value;
		}

		return parent::convertToDatabaseValue($value->getValue(), $platform);
	}

	public function convertToPHPValue($value, AbstractPlatform $platform)
	{
		return Id::fromString($value);
	}

	public function getName(): string
	{
		return self::NAME;
	}

	public function requiresSQLCommentHint(AbstractPlatform $platform): bool
	{
		return true;
	}
}