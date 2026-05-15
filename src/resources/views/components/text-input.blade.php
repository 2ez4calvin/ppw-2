@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'input-custom rounded-md shadow-sm']) }}>
