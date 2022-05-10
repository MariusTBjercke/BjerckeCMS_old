<?php

declare(strict_types=1);

namespace Bjercke\Enum;

enum AddonLevel: int {
    case Normal = 0;
    case TBC = 1;
    case WotLK = 2;
}