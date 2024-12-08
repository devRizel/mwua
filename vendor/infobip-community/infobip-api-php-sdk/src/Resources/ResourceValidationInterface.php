<?php

declare(strict_types=1);

namespace Infobip\Resources;

use Infobip\Validations\Rules;

interface ResourceValidationInterface
{
    public function rules(): Rules;
}
