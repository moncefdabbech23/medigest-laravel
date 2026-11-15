@props(['name', 'label', 'value' => '', 'rows' => 3])

<div>
    <label for="{{ $name }}">{{ $label }}</label>
    <textarea id="{{ $name }}" name="{{ $name }}" rows="{{ $rows }}" {{ $attributes }}>{{ old($name, $value) }}</textarea>
    @error($name)
        <div class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</div>
    @enderror
</div>
