@aware(['headClasses' => 'bg-gray-50/90 dark:bg-gray-800/90 text-gray-700 dark:text-gray-200'])

<thead {{ $attributes->class([
    $headClasses,
    $stickyClasses,
    'relative z-10',
]) }}>
    {{ $slot }}
</thead>
