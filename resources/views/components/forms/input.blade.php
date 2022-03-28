@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-slate-700 text-black focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 rounded-md shadow-sm']) !!}>
