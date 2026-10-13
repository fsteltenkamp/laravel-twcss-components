<?php

namespace Fsteltenkamp\TwcssComponents\View\Components\Form\Input;

/**
 * Time picker (HH:MM). min, max and step pass through as attributes.
 * Props and view are Text's.
 */
class Time extends Text
{
    protected string $defaultType = 'time';
}
