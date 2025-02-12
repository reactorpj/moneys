<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\User\Type;

use App\Domain\Type\UserRole;
use App\Domain\ValueObject\User\Role;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\JsonType;

class RoleType extends JsonType
{
	public const NAME = 'user_user_role';

	public function convertToPHPValue($value, AbstractPlatform $platform): Role
	{
		$roles = parent::convertToPHPValue($value, $platform);

		return Role::fromArray(array_map(fn (string $role) => UserRole::from($role), $roles));
	}

	public function convertToDatabaseValue($value, AbstractPlatform $platform): string
	{
		$roles = array_map(fn (UserRole $role) => $role->value, $value->getValue());

		return parent::convertToDatabaseValue($roles, $platform);
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