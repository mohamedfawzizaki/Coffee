<?php

namespace App\Enums;

enum ContactStatus: string
{
    case New = 'new';
    case Open = 'open';
    case Solved = 'solved';
    case Closed = 'closed';
}
