@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'dropdown-menu'])

<div class="dropdown" {{ $attributes }}>
    <div class="dropdown-toggle" data-bs-toggle="dropdown">
        {{ $trigger }}
    </div>
    <div class="dropdown-menu {{ $align === 'right' ? 'dropdown-menu-end' : '' }} shadow-lg border-0 rounded-4 p-2">
        {{ $content }}
    </div>
</div>
