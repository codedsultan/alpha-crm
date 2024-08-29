@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-pink-500 focus:ring-blue-500 rounded-md shadow-sm']) !!}>
