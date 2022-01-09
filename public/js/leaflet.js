// Création du marker
let gm = [44.26116391784021, 2.3652362823486333];

// création de la map
let map = L.map('maps').setView(gm, 6);

//Création du calque images
L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
    maxZoom: 20
}).addTo(map);

// Ajout d'un marker
let marker = L.marker(gm).addTo(map);

// Ajout d'un popup
marker.bindPopup('<h4> Weddevsegala, Gramond, FRANCE </h4>');