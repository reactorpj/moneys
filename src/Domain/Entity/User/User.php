<?php

declare(strict_types=1);

namespace App\Domain\Entity\User;

use App\Domain\Type\UserRole;
use App\Domain\ValueObject\User\Email;
use App\Domain\ValueObject\User\Id;
use App\Domain\ValueObject\User\Password;
use App\Infrastructure\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Table(name: 'user_users', uniqueConstraints: [new UniqueEntity(['fields' => 'email'])])]
#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
	#[ORM\Id]
	#[ORM\Column(type: 'user_user_id', length: 36)]
	#[Assert\NotBlank]
	private Id $id;

	#[ORM\Column(type: 'user_user_email', length: 255)]
	#[Assert\NotBlank]
	private Email $email;

	#[ORM\Column(type: 'user_user_role', length: 255)]
	#[Assert\NotBlank]
	private array $roles;

	#[ORM\Embedded(class: Password::class, columnPrefix: '')]
	private Password $passwordHash;

	private function __construct(
		Id    $id,
		Email $email,
		Password $password,
	)
	{
		$this->id = $id;
		$this->email = $email;
		$this->roles = [UserRole::USER];
		$this->passwordHash = $password;
	}

	public static function create(Id $id, Email $email, Password $password): self
	{
		return new self($id, $email, $password);
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
		$roles = $this->roles;
		// guarantee every user at least has ROLE_USER
		$roles[] = UserRole::USER;

		return array_unique($roles);
	}

	/**
	 * @param UserRole[] $roles
	 */
	public function setRoles(array $roles): static
	{
		$this->roles = $roles;

		return $this;
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
		// If you store any temporary, sensitive data on the user, clear it here
		// $this->plainPassword = null;
	}
}
