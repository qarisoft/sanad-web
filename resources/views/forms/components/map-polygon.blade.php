
@php use Filament\Support\Facades\FilamentAsset; @endphp
<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
><div
        x-ignore
        ax-load
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
        wire:ignore>
        <div
            x-ref="salah"
            class="w-full"
            style="
                min-height: 60vh;
                z-index: 1 !important;
            "
        ></div>
    </div>

    <script>
        let center = { lat: 21.530308, lng: 39.194255 };
        let map;
        function polygonComponent({state,mapEl}) {
            return {
                state,
                get mode() {
                    return window.location.href.substring(window.location.href.lastIndexOf('/') + 1);
                },
                async crateMap() {
                    const d = await google.maps.importLibrary('drawing');
                    const { Map } = await google.maps.importLibrary("maps");
                    // const { AdvancedMarkerElement } =  await google.maps.importLibrary("marker");
                    const polygons = []
                    map = new Map(mapEl, {
                        center,
                        zoom: 6,
                        mapId: "da7f6fc161313e59",
                        mapTypeControl: true,
                        disableDefaultUI:true,

                    });
                    this.$watch("state", () => {
                        if (this.state === null || this.state===undefined) {
                            return;
                        }
                        console.log("from watch", this.state);
                    });
                    const mode = this.mode;
                    let state= this.state
                    const update=(points)=> this.reState(points)
                    const dos = function (){
                        if (mode==='create'){

                            const drawingManager = new google.maps.drawing.DrawingManager({
                                drawingMode: google.maps.drawing.OverlayType.POLYGON,
                                drawingControl: true,
                                drawingControlOptions: {
                                    position: google.maps.ControlPosition.TOP_CENTER,
                                    drawingModes: [
                                        google.maps.drawing.OverlayType.POLYGON,
                                    ],
                                },
                                polygonOptions:
                                    {strokeWeight: 1,
                                        clickable: true,
                                        editable: true,
                                        zIndex: 1,
                                    },
                            });
                            drawingManager.setMap(map);
                            drawingManager.addListener('polygoncomplete',function (e){
                                polygons.forEach((a)=>polygons.pop())
                                drawingManager.setDrawingMode(null)
                                polygons.push(e)

                                const points = []
                                e.getPath().forEach((point)=>{
                                    points.push({
                                        lat:point.lat(),
                                        lng:point.lng()
                                    })
                                })
                                update(points)
                                e.addListener('mouseup', (ad) => {
                                    const s=[]
                                    e.getPath().forEach((a) => {
                                        s.push( { lat: a.lat(), lng: a.lng() })
                                    })
                                    update(s)
                                })
                            })
                        }else {
                            let polyg = new google.maps.Polygon({
                                strokeOpacity: 0.8,
                                strokeWeight: 1,
                                fillOpacity: 0.1,
                                paths:JSON.parse(state),
                                geodesic:true,
                                zIndex:1000
                            })
                            polyg.setMap(map)
                            let latlngbounds = new google.maps.LatLngBounds();
                            polyg.getPath().forEach((loc)=>{
                                latlngbounds.extend(loc)
                            })
                            map.setCenter(latlngbounds.getCenter())
                            map.fitBounds(latlngbounds)
                        }
                    }
                    google.maps.event.addListenerOnce(map, 'tilesloaded', function(){
                        dos()

                    });
                },
                reState(points) {
                    if (points?.length>0){
                        this.state = points;
                    }
                },
                init: function() {
                    this.crateMap();
                }
            };
        }
    </script>
</x-dynamic-component>
