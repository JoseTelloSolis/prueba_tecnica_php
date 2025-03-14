<?php

declare(strict_types=1);

namespace App\Domain\User\Exception;

use InvalidArgumentException;

final class UserAlreadyExistsException extends InvalidArgumentException
{
}
