@props(['compact' => false])

<span {{ $attributes->class('inline-flex items-center gap-3 font-bold tracking-tight text-ink-950') }}>
    <span class="grid size-10 shrink-0 place-items-center rounded-xl bg-ink-950 text-sm text-white shadow-sm" aria-hidden="true">
        CN
    </span>
    @unless ($compact)
        <span class="text-lg">Colors Nepal</span>
    @endunless
</span>
