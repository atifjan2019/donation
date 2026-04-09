@props(['active' => false])
<a {{ $attributes->merge(['class' => 'nav-link px-3 rounded-3' . ($active ? ' active fw-semibold' : '')]) }}>
    {{ $slot }}
</a>
