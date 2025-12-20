<?php

namespace App\Enums;

enum LetterState: string
{
    case PRESENT = 'present';
    case ABSENT = 'absent';
    case CORRECT = 'correct';
}
