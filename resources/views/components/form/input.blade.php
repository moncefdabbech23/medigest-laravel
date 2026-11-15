@props(['name', 'label', 'type' => 'text', 'value' => ''])

<div>
    <label for="{{ $name }}">{{ $label }}</label>
    <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}"
           value="{{ $type === 'password' ? '' : old($name, $value) }}"
           {{ $attributes->merge(['class' => $errors->has($name) ? 'border-rose-400' : '']) }}>
    @error($name)
        <div class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</div>
    @enderror
</div>
