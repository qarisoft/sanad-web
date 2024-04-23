@php use Filament\Support\Facades\FilamentAsset;@endphp
<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>

    <div
        x-ignore
        ax-load
        x-data="areaComponent({

            state: $wire.{{ $applyStateBindingModifiers("\$entangle('{$getStatePath()}')") }},
            polygons:@js($getPolygons()),
            mapEl: $refs.salah,
        })"
        id="{{ $getId() . '-alpine' }}"
        wire:ignore
    >
        {{--        <div class="">{{ $getPolygons() }}</div>--}}
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
        var center = {lat: 21.530308, lng: 39.194255};
        var styleDefault = {
            strokeColor: "#2783f2",
            strokeOpacity: 1,
            strokeWeight: 1,
            fillColor: "white",
            fillOpacity: 0.1
        };
        var styleClicked = {
            ...styleDefault,
            fillColor: "#2783f2",
            fillOpacity: 0.5
        };
        var styleMouseMove = {
            ...styleDefault,
            strokeWeight: 2,
            strokeColor: "#4e8ede",
            fillColor: "#2783f2",
            fillOpacity: 0.1
        };
        var lastInteractedFeatureIds = [];
        var lastClickedFeatureIds = [];
        var featureLayer;
        const saudiCities = [
            "ChIJEzBjOaRwAT4RGxyMEbYDH5s",
            "ChIJhWCB2EZI7xURg8hZoRUVLZY",
            "ChIJSzet3A40bhURA1BCESBhSU8",
            "ChIJi8egT-QmDRURauBXzcDVuOw",
            "ChIJG2op1WXnuRUR8PHAuu4aUjA",
            "ChIJO77ib61ZfxURqgANOx1i--E",
            "ChIJwS4u9s4DJz4R1GIN45_BpL4",
            "ChIJhYY947MZQD4Rpli7AuRzsW0",
            "ChIJaSIjDKQidhURk7Cr1kLXx1o",
            "ChIJE9USGEcl4hURmz1R5mfY8zo",
            "ChIJWX4TsR_QwxURGOVE2IRJ6PM",
            "ChIJ45zbxwfr_hURfzOBUQX8Cqs",
            "ChIJZSMTlAWtqRURYmPqLhZQMbs"

        ]

        function applyStyle(params) {
            const placeId = params.feature.placeId;
            if (lastClickedFeatureIds.includes(placeId)) {
                return styleClicked;
            }
            if (lastInteractedFeatureIds.includes(placeId)) {
                return styleMouseMove;
            }
            if (saudiCities.includes(placeId)) {

                return styleDefault;
            }
        }

        function handleClick(e) {
            lastClickedFeatureIds = e.features.map((f) => f.placeId);
            lastInteractedFeatureIds = [];
            featureLayer.style = applyStyle;

            console.log(featureLayer)
        }

        function handleMouseMove(e) {
            lastInteractedFeatureIds = e.features.map((f) => f.placeId);
            featureLayer.style = applyStyle;
        }

        let map;

        function areaComponent({
                                   state,
                                   polygons,
                                   mapEl,
                               }) {
            return {
                state,
                polygons,

                get mode() {
                    return window.location.href.substring(window.location.href.lastIndexOf('/') + 1);
                },
                async crateMap() {

                    const {Map} = await google.maps.importLibrary("maps");
                    const {AdvancedMarkerElement} = await google.maps.importLibrary("marker");
                    map = new Map(mapEl, {
                        center,
                        zoom: 6,
                        mapId: "da7f6fc161313e59",
                        mapTypeControl: false,
                        disableDefaultUI: true
                    });
                    const mode = this.mode;
                    let current;
                    if (mode !== 'create') {
                        let p_data = polygons.filter((a)=>a.place_id===this.state.place_id)[0]
                        current = new google.maps.Polygon({
                            strokeOpacity: 0.8,
                            strokeWeight: 1,
                            fillOpacity: 0.1,
                            paths: JSON.parse(p_data.data),
                            geodesic: true,
                            // zIndex:1000,
                            place_id: p_data.place_id
                        })
                        current.setMap(map)
                        if (this.state !== null && this.state.place_id) {
                            let a = new google.maps.LatLng(this.state.lat, this.state.lng)
                            // map.setCenter(a)
                        }
                            let latlngbounds = new google.maps.LatLngBounds();
                            current.getPath().forEach((loc)=>{
                                latlngbounds.extend(loc)
                            })
                            map.setCenter(latlngbounds.getCenter())
                            map.fitBounds(latlngbounds)
                    }
                    console.log(mode)
                    if (mode !== 'view') {
                        this.$watch("state", () => {
                            console.log("from watch", this.state);
                            if (this.state !== null) {
                                console.log(this.state)
                            }
                        });
                        for (let i = 0; i < polygons.length; i++) {
                            let polyg = new google.maps.Polygon({
                                strokeOpacity: 0.8,
                                strokeWeight: 1,
                                fillOpacity: 0,
                                paths: JSON.parse(polygons[i].data),
                                geodesic: true,
                                // zIndex:1000,
                                place_id: polygons[i].place_id
                            })
                            polyg.setMap(map)
                            polyg.addListener('click', (e) => {
                                current?.set('fillOpacity', 0)
                                current = polyg;
                                current.set('fillOpacity', 0.1)
                                    this.state = {
                                        ...this.state,
                                        lat: e.latLng.lat(),
                                        lng: e.latLng.lng(),
                                        place_id: current.place_id
                                    };

                            })
                        }
                    }



                },
                init: function () {
                    this.crateMap();

                }
            };
        }
    </script>
</x-dynamic-component>
