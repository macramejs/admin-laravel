<?php

namespace App\Models\Types;

enum NavType: string
{
    /**
     * Main navigation.
     */
    case Main = 'main';

    /**
     * Footer navigation.
     */
    case Footer = 'footer';
}
