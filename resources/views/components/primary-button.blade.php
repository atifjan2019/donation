<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-gradient']) }}>
    {{ $slot }}
</button>
