<?php

namespace Fsteltenkamp\TwcssComponents\Support;

/**
 * Active-link detection shared by the navbar and sidebar links.
 */
class ActiveUrl
{
    /**
     * Whether the current request matches the link: by the Request::is() pattern when
     * given, otherwise by the href's path. `#` and empty paths never match.
     */
    public static function matches(string $href, ?string $activePattern = null): bool
    {
        $pattern = $activePattern ?? trim((string) parse_url($href, PHP_URL_PATH), '/');

        if ($pattern === '' || $href === '#') {
            return false;
        }

        return request()->is($pattern);
    }
}
