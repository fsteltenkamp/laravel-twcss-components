<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Form\Input;

/**
 * Numeric input. min, max, step and inputmode pass through as attributes.
 * Props and view are Text's.
 */
class Number extends Text
{
    protected string $defaultType = 'number';
}
