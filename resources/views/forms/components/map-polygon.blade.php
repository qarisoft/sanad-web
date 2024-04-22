
@php use Filament\Support\Facades\FilamentAsset; @endphp



<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div
        x-ignore
        ax-load
        ax-load-src="{{ FilamentAsset::getAlpineComponentSrc('map-polygon-component') }}"
        x-data="polygonComponent({

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
        <script>
{{--            {{ $operation() }}--}}
        </script>
{{--    <div class="" x-text="  {{ $operation() }}"></div>--}}
        <div
            x-ref="salah"
            class="w-full"
            style="
                min-height: 60vh;
                z-index: 1 !important;
            "
        ></div>
    </div>
</x-dynamic-component>
