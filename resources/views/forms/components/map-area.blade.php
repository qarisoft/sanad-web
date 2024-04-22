@php use Filament\Support\Facades\FilamentAsset;
 $paths1 = $getStatePath();
 @endphp
<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>

    <div
        x-ignore
        ax-load
        ax-load-src="{{ FilamentAsset::getAlpineComponentSrc('map-area-component') }}"
        x-data="areaComponent({

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
{{--        <div class="z-10" x-text="$wire.{{ $applyStateBindingModifiers("\$entangle('{$getStatePath()}')") }}">--}}
{{--            dasdadas--}}
{{--        </div>--}}
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
