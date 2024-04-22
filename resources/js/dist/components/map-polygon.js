var center = { lat: 21.530308, lng: 39.194255 };

let map;
function polygonComponent({
                              state,
                              operation,
                              setStateUsing,
                              getStateUsing,
                              mapEl,
                              defaultLocation = { lat: 0, lng: 0 }
                          }) {
    return {
        state,
        operation,
        getCoordinates: function() {
            if (this.state === null || !this.state.hasOwnProperty("lat")) {
                this.state = { lat: defaultLocation.lat, lng: defaultLocation.lng };
            }
            return this.state;
        },
        get mode() {
            return window.location.href.substring(window.location.href.lastIndexOf('/') + 1);
        },
        // get mode =>{},
        async crateMap() {
            const d = await google.maps.importLibrary('drawing');
            const { Map } = await google.maps.importLibrary("maps");
            // const { AdvancedMarkerElement } =  await google.maps.importLibrary("marker");
            const polygons = []
            map = new Map(mapEl, {
                center,
                zoom: 6,
                mapId: "da7f6fc161313e59",
                mapTypeControl: false,
                disableDefaultUI:true
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
                        // polygons.length>0?polygons.pop():null;
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
                console.log('tilesloaded')
                //this part runs when the mapobject is created and rendered
                dos()

            });
        },
        reState(points) {
            if (points?.length>0){
                this.state = points;
                // console.log(this.state)
            }
        },
        init: function() {
            this.crateMap();
        }
    };
}
export {
    polygonComponent as default
};
