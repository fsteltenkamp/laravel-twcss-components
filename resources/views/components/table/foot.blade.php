@aware(['footClasses' => 'bg-gray-50/90 dark:bg-gray-800/90 text-gray-700 dark:text-gray-200'])

<tfoot {{ $attributes->class([$footClasses]) }}>
    {{ $slot }}
</tfoot>
