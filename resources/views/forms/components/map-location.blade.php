@php use Filament\Support\Facades\FilamentAsset; @endphp

<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>

    <div
        x-ignore
        ax-load
        ax-load-src="{{ FilamentAsset::getAlpineComponentSrc('map-location-component') }}"
        x-data="locationComponent({

            state: $wire.{{ $applyStateBindingModifiers("\$entangle('{$getStatePath()}')") }},
            setStateUsing: (path, state) => {
                return $wire.set(path, state)
            },
            getStateUsing: (path) => {
                return $wire.get(path)
            },
            mapEl: $refs.salah,
        })"
        id="{{ $getId() . '-alpine' }}"
        wire:ignore
    >
        <div
            x-ref="salah"
            class="w-full"
            style="
                min-height: 40vh;
                z-index: 1 !important;
            "
        ></div>
    </div>
</x-dynamic-component>
