<?php

declare(strict_types=1);

namespace Bjercke\Enum;

enum AccountLevel: int {
    case Player = 0;
    case Moderator = 1;
    case GameMaster = 2;
    case Admin = 3;
}