<?php

declare(strict_types=1);

namespace App\Domain\Entity\User;

use App\Domain\ValueObject\User\Email;
use App\Domain\ValueObject\User\Id;
use App\Domain\ValueObject\User\Password;
use App\Domain\ValueObject\User\Role;
use App\Infrastructure\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Table(name: 'user_users')]
#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
	#[ORM\Id]
	#[Column(type: 'user_user_id', length: 36)]
	#[Assert\NotBlank]
	private Id $id;

	#[Column(type: 'user_user_email', length: 255)]
	#[Assert\NotBlank]
	private Email $email;

	#[Column(type: 'user_user_role', length: 255)]
	#[Assert\NotBlank]
	private Role $roles;

	#[ORM\Embedded(class: Password::class, columnPrefix: false)]
	private Password $passwordHash;

	private function __construct(
		Id       $id,
		Email    $email,
		Password $password,
		Role $roles,
	)
	{
		$this->id = $id;
		$this->email = $email;
		$this->roles = $roles;
		$this->passwordHash = $password;
	}

	public static function createForUser(Id $id, Email $email, Password $password): self
	{
		return new self($id, $email, $password, Role::fromArray([Role::ROLE_USER]));
	}

	/**
	 * @return Id
	 */
	public function getId(): Id
	{
		return $this->id;
	}

	/**
	 * @param Id $id
	 * @return void
	 */
	public function setId(Id $id): void
	{
		$this->id = $id;
	}

	/**
	 * @return Email
	 */
	public function getEmail(): Email
	{
		return $this->email;
	}

	/**
	 * @param Email $email
	 * @return void
	 */
	public function setEmail(Email $email): void
	{
		$this->email = $email;
	}

	/**
	 * A visual identifier that represents this user.
	 *
	 * @see UserInterface
	 */
	public function getUserIdentifier(): string
	{
		return $this->email->getValue();
	}

	public function getRoles(): array
	{
		return $this->roles->getValue();
	}

	/**
	 * @param Role $roles
	 * @return $this
	 */
	public function setRoles(Role $roles): static
	{
		$this->roles = $roles;

		return $this;
	}

	/**
	 * @param string $role
	 * @return void
	 */
	public function addRole(string $role): void
	{
		$this->roles = Role::fromArray([...$this->roles->getValue(), Role::ROLE_USER]);
	}

	/**
	 * @see PasswordAuthenticatedUserInterface
	 */
	public function getPassword(): string
	{
		return $this->passwordHash->getValue();
	}

	public function setPassword(Password $password): void
	{
		$this->passwordHash = $password;
	}

	/**
	 * @see UserInterface
	 */
	public function eraseCredentials(): void
	{
	}
}
