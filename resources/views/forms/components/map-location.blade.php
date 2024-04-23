@php use Filament\Support\Facades\FilamentAsset; @endphp

<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>

    <div
        x-ignore
        ax-load
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
    <script>
    var center = { lat: 21.530308, lng: 39.194255 };

    let map;
    function locationComponent({
                                state,
                                setStateUsing,
                                getStateUsing,
                                mapEl,
                                defaultLocation = { lat: 0, lng: 0 }
                            }) {
        return {
            state,
            get mode() {
                return window.location.href.substring(window.location.href.lastIndexOf('/') + 1);
            },
            async crateMap() {

                const { Map } = await google.maps.importLibrary("maps");
                const { AdvancedMarkerElement } =  await google.maps.importLibrary("marker");
                map = new Map(mapEl, {
                    center,
                    zoom: 6,
                    mapId: "da7f6fc161313e59",
                    mapTypeControl: true,
                    disableDefaultUI:true,
                });
                console.log(this.mode)
                let c = {lat:0,lng:0};
                if (this.mode!=='create'){
                    c.lat = this.state.lat?parseFloat(this.state.lat):0
                    c.lng = this.state.lng?parseFloat(this.state.lng):0

                }
                const marker = new AdvancedMarkerElement ({
                    map: map,
                    position: c,
                });
                const update = (e)=>{

                    this.state={
                        lat: e.latLng.lat(),
                        lng: e.latLng.lng(),
                    }
                    marker.position=e.latLng
                }
                google.maps.event.addListenerOnce(map, 'tilesloaded', function(){
                    map.addListener('click', (e)=>{
                        update(e);
                    })

                });
                this.$watch("state", () => {
                    console.log("from watch", this.state);
                    if (this.state !== null) {
                        console.log(this.state)
                    }
                });
            },
            init: function() {
                this.crateMap();
            }
        };
    }
    </script>
</x-dynamic-component>
