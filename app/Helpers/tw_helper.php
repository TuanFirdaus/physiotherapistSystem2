<?php

if (!function_exists('tw')) {
    /**
     * Prefix all Tailwind classes with 'tw-' to avoid conflicts.
     *
     * @param string $classString Space-separated list of Tailwind classes.
     * @return string Prefixed Tailwind classes.
     */
    function tw(string $classString): string
    {
        // Ignore empty input
        if (trim($classString) === '') {
            return '';
        }

        $classes = preg_split('/\s+/', $classString);
        $prefixed = [];

        foreach ($classes as $cls) {
            // Avoid double prefixing or skipping pseudo/variant classes
            if (str_starts_with($cls, 'tw-')) {
                $prefixed[] = $cls;
                continue;
            }

            // Handle responsive and pseudo variants (e.g., md:flex, hover:bg-blue-500)
            if (str_contains($cls, ':')) {
                $parts = explode(':', $cls);
                $last = array_pop($parts);
                $parts[] = 'tw-' . $last;
                $prefixed[] = implode(':', $parts);
            } else {
                $prefixed[] = 'tw-' . $cls;
            }
        }

        return implode(' ', $prefixed);
    }
}
