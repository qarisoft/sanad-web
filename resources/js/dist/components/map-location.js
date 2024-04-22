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


            const marker = new AdvancedMarkerElement ({
                map: map,
                position: { lat: 0, lng: 0 },
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
                    // return;
                    console.log(this.state)
                }
            });
        },
        init: function() {
            this.crateMap();
        }
    };
}
export {
    locationComponent as default
};
