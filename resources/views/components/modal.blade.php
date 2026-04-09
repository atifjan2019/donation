@props([
    'name',
    'show' => false,
    'maxWidth' => '2xl'
])

@php
$maxWidth = [
    'sm' => 'modal-sm',
    'md' => '',
    'lg' => 'modal-lg',
    'xl' => 'modal-xl',
    '2xl' => 'modal-xl',
][$maxWidth];
@endphp

<div x-data="{ show: @js($show) }"
     x-on:open-modal.window="$event.detail == '{{ $name }}' && (show = true)"
     x-on:close-modal.window="$event.detail == '{{ $name }}' && (show = false)"
     x-on:close.stop="show = false"
     x-on:keydown.escape.window="show = false">

    <div class="modal fade" :class="show && 'show d-block'" tabindex="-1" x-show="show" style="background:rgba(0,0,0,0.5)">
        <div class="modal-dialog {{ $maxWidth }} modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow-lg" @click.outside="show = false">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
