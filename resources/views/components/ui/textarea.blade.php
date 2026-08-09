@props([
    'label',
    'name',
    'value' => null,
    'help' => null,
    'required' => false,
    'rows' => 5,
])

<label class="block">
    <span class="mb-2 block text-sm font-semibold text-slate-800">
        {{ $label }}
        @if ($required)<span class="text-red-600" aria-hidden="true">*</span>@endif
    </span>

    <textarea
        name="{{ $name }}"
        rows="{{ $rows }}"
        @required($required)
        @if ($errors->has($name)) aria-invalid="true" aria-describedby="{{ $name }}-error" @elseif ($help) aria-describedby="{{ $name }}-help" @endif
        {{ $attributes->class('w-full rounded-control border border-slate-300 bg-white px-3.5 py-2.5 text-slate-950 shadow-sm placeholder:text-slate-400 hover:border-slate-400 focus:border-brand-600 focus:ring-2 focus:ring-brand-100') }}
    >{{ old($name, $value) }}</textarea>

    @error($name)
        <span id="{{ $name }}-error" class="mt-2 block text-sm text-red-700">{{ $message }}</span>
    @elseif ($help)
        <span id="{{ $name }}-help" class="mt-2 block text-sm text-slate-500">{{ $help }}</span>
    @enderror
</label>
