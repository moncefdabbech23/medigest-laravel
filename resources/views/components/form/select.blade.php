@props(['name', 'label', 'options' => [], 'selected' => null, 'placeholder' => '— Choisir —'])

<div>
    <label for="{{ $name }}">{{ $label }}</label>
    <select id="{{ $name }}" name="{{ $name }}" {{ $attributes }}>
        <option value="">{{ $placeholder }}</option>
        @foreach ($options as $value => $text)
            <option value="{{ $value }}" @selected(old($name, $selected) == $value)>{{ $text }}</option>
        @endforeach
    </select>
    @error($name)
        <div class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</div>
    @enderror
</div>
