<?php

namespace App\Support;

/**
 * Turns admin-entered links into hrefs.
 *
 * "/about" or "about" becomes a URL inside the app (works when installed in a sub-folder),
 * while absolute URLs, anchors, mailto: and tel: links are returned unchanged.
 */
class Link
{
    public static function to(?string $link, string $fallback = '#'): string
    {
        $link = trim((string) $link);

        if ($link === '') {
            return $fallback;
        }

        if (preg_match('#^([a-z][a-z0-9+.-]*:|//|\#)#i', $link)) {
            return $link;
        }

        return url($link);
    }

    public static function tel(?string $phone): string
    {
        return 'tel:' . preg_replace('/[^0-9+]/', '', (string) $phone);
    }

    public static function isExternal(?string $link): bool
    {
        return (bool) preg_match('#^(https?:)?//#i', (string) $link)
            && !str_starts_with((string) $link, rtrim(config('app.url'), '/'));
    }
}
