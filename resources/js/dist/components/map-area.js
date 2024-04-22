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
                           setStateUsing,
                           getStateUsing,
                           mapEl,
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
                mapTypeControl: false,
                disableDefaultUI:true
            });
            const mode = this.mode;
            // const marker = new AdvancedMarkerElement ({
            //     map: map,
            //     position: { lat: 0, lng: 0 },
            // });
            if (mode!=='create'){
                console.log(this.state.place_id)
                if (this.state!=null && this.state.place_id){
                    lastClickedFeatureIds[0]=this.state.place_id
                    let a = new google.maps.LatLng(this.state.lat, this.state.lng)
                    map.setCenter(a)
                }
            }
            featureLayer = map.getFeatureLayer("ADMINISTRATIVE_AREA_LEVEL_1");
            featureLayer.style = applyStyle;
            if (mode!=='view'){
                console.log('view')
                featureLayer.addListener("click", (e) => {
                    handleClick(e);
                    this.state = {
                        ...this.state,
                        lat: e.latLng.lat(),
                        lng: e.latLng.lng(),
                        place_id: lastClickedFeatureIds[0]
                    };
                });
                featureLayer.addListener("mousemove", handleMouseMove);
            }
        },
        init: function() {
            this.crateMap();

        }
    };
}
export {
    areaComponent as default
};
