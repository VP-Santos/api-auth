<?php

namespace App\Domains\Admin\Enums;

enum UserAccessLevel: string
{
    case ADMIN = 'admin';
    case BASIC = 'basic';
}