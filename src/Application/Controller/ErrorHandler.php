<?php

declare(strict_types=1);

namespace App\Application\Controller;

use Psr\Log\LoggerInterface;

readonly class ErrorHandler
{
	public function __construct(private LoggerInterface $logger) { }

	public function handle(\DomainException $exception): void
	{
		$this->logger->warning($exception->getMessage(), ['exception' => $exception]);
	}
}