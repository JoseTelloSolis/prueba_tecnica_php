<?php

declare(strict_types=1);

namespace App\Infrastructure\Events;

use App\Domain\User\UserRegisteredEvent;

final class SendWelcomeEmailHandler
{
    public function handle(UserRegisteredEvent $event): void
    {
        // Simular el envío de un email (en un caso real se invocaría un servicio de email)
        error_log("Sending welcome email to: " . $event->getEmail()->getValue());
    }
}
