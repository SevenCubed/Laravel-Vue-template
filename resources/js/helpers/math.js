export 
function geoDistance(latBuyer, latSeller, lonBuyer, lonSeller) {
    //φ and λ just look much more *mathematical* than phi and lam, but too bad.
    const R = 6371000 //Radius of the Earth, in m
    const phiBuyer = latBuyer * Math.PI/180; //conversion to radians
    const phiSeller = latSeller * Math.PI/180;
    const dPhi = (latSeller - latBuyer) * ( Math.PI / 180 );
    const dLam = (lonSeller - lonBuyer) * ( Math.PI / 180 );

    const a = Math.pow(Math.sin(dPhi / 2),2) + Math.cos(phiSeller) * Math.cos(phiBuyer) * Math.pow(Math.sin(dLam / 2), 2); 
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    const d = R * c //in m
    return d
};