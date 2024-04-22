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
    var styleDefault = {
        strokeColor: "#2783f2",
        strokeOpacity: 1,
        strokeWeight: 1,
        fillColor: "white",
        fillOpacity: 0.1
    };
    var styleClicked = {
        ...styleDefault,
        fillOpacity: 0.1
    };
    var styleMouseMove = {
        ...styleDefault,
        fillOpacity: 0.1
    };
    var lastInteractedFeatureIds = [];
    var lastClickedFeatureIds = [];
    function applyStyle(params) {
        const placeId = params.feature.placeId;
        if (lastClickedFeatureIds.includes(placeId)) {
            return styleClicked;
        }
        if (lastInteractedFeatureIds.includes(placeId)) {
            return styleMouseMove;
        }
        return styleDefault;
    }
    var featureLayer;
    function handleClick(e) {
        lastClickedFeatureIds = e.features.map((f) => f.placeId);
        lastInteractedFeatureIds = [];
        featureLayer.style = applyStyle;

    }
    function handleMouseMove(e) {
        lastInteractedFeatureIds = e.features.map((f) => f.placeId);
        featureLayer.style = applyStyle;
    }
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
            async crateMap() {

                const { Map } = await google.maps.importLibrary("maps");
                const { AdvancedMarkerElement } =  await google.maps.importLibrary("marker");
                map = new Map(mapEl, {
                    center,
                    zoom: 6,
                    mapId: "da7f6fc161313e59",
                    // mapTypeControl: false
                });
                let c = {

                }
                console.log(this.state);
                c.lat = parseFloat(this.state.lat)
                if (! this.state.lat) {
                    c.lat=0
                }
                c.lng = parseFloat(this.state.lng)
                if(! this.state.lng){
                    c.lng=0
                }
                const marker = new AdvancedMarkerElement ({
                    map: map,
                    position: c,
                });
                const update = (e)=>{
                    this.state={
                        lat: e.latLng.lat(),
                        lng: e.latLng.lng(),
                        place_id: lastClickedFeatureIds[0]
                    }
                }
                google.maps.event.addListenerOnce(map, 'tilesloaded', function(){
                    featureLayer = map.getFeatureLayer("ADMINISTRATIVE_AREA_LEVEL_1");
                    featureLayer.style = applyStyle;
                    featureLayer.addListener("click", (e) => {
                        handleClick(e);
                        update(e);
                        marker.position = e.latLng
                    });
                    featureLayer.addListener("mousemove", handleMouseMove);
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
