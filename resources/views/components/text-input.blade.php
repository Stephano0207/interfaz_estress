
@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' => 'border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-lg shadow-sm p-3 w-full'
]) !!}>
