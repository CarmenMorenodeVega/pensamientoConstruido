/*
 * Carmen Moreno de Vega.Junio 2019
 */
'use strict';

// Create viewer.
var viewer = new Marzipano.Viewer(document.getElementById('pano'));

// Create source.
var source = Marzipano.ImageUrlSource.fromString(
  "1d_stitch.png"
);

// Create geometry.
var geometry = new Marzipano.CubeGeometry([{ tileSize: 1024, size: 1024 }]);

/*// Create geometry.
var geometry = new Marzipano.CubeGeometry([
  { tileSize: 256, size: 256, fallbackOnly: true },
  { tileSize: 512, size: 512 },
  { tileSize: 512, size: 1024 },
  { tileSize: 512, size: 2048 },
  { tileSize: 512, size: 4096 }
]);*/

// Create view.
var limiter = Marzipano.RectilinearView.limit.traditional(2300, 100*Math.PI/180);
var view = new Marzipano.RectilinearView(null, limiter);

// Create scene.
var scene = viewer.createScene({
  source: source,
  geometry: geometry,
  view: view,
  pinFirstLevel: true
});

// Display scene.
scene.switchTo();

// Get the hotspot container for scene.
var container = scene.hotspotContainer();

// Create hotspot with different sources.
container.createHotspot(document.getElementById('iframespot'), { yaw: 0.0335, pitch: -0.102 },
  { perspective: { radius: 1640, extraRotations: "rotateX(5deg)" }});
container.createHotspot(document.getElementById('iframeselect'), { yaw: -0.35, pitch: -0.239 });

// HTML sources.
var hotspotHtml = {
  previo: '<iframe id="previo" width="1604" height="900" src="4.jpg" frameborder="0" allowfullscreen></iframe>',
  tourVR: '<iframe id="tourVR" width="1604" height="900" src="http://www.paneek.net/#/tour/view/7095" frameborder="0" allowfullscreen="true"></iframe>',
  quienesSomos: '<iframe id="quienesSomos" width="1604" height="900" src="http://www.pensamientoconstruido.epizy.com/Views/layout.main.html" frameborder="0" allowfullscreen="true"></iframe>',
  galeria: '<iframe id="galeria" width="1604" height="900" src="../galeria/app-files/index.html" width="1280" height="700" frameborder="0" style="border:0" allowfullscreen="true"></iframe>',
  iniciarSesion: '<iframe id="iniciarSesion" width="1604" height="900" src="http://www.pensamientoconstruido.epizy.com" type="text/html" width="1280" height="480" frameborder="0" allowfullscreen="true"> </iframe>',
  verLibros: '<iframe id="verLibros" width="1604" height="900" src="http://pensamientoconstruido.epizy.com/Views/indexbook.php" type="text/html" width="1280" height="480" frameborder="0" allowfullscreen="true"> </iframe>',
  arquitectos: '<iframe id="arquitectos" width="1604" height="900" src="https://www.cosasdearquitectos.com/category/cultura/frases-de-arquitectos/" width="1280" height="480" frameborder="0" allowfullscreen="true"> </iframe>',
  obrasDestacadas: '<iframe id="obrasDestacadas" width="1604" height="900" src="https://www.arrevol.com/blog/10-videos-y-documentales-de-arquitectura-que-no-te-puedes-perder" width="1280" height="480" frameborder="0" allowfullscreen="true"> </iframe>'
};

// Switch sources when clicked.
function switchHotspot(id) {
  var wrapper = document.getElementById('iframespot');
  wrapper.innerHTML = hotspotHtml[id];
}

var switchElements = document.querySelectorAll('[data-source]');
for (var i = 0; i < switchElements.length; i++) {
  var element = switchElements[i];
  addClickEvent(element);
}

function addClickEvent(element) {
  element.addEventListener('click', function() {
  	/*if (element.getAttribute('data-source')="previo")*/
    switchHotspot(element.getAttribute('data-source'));
  });
}
