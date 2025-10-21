<?php
// Simple router-ish by query param 'p'
$p = isset($_GET['p']) ? $_GET['p'] : 'home';
function nav_link($p, $label){
    $active = ($_GET['p'] ?? 'home') === $p ? 'active' : '';
    echo "<li class='nav-item'><a class='nav-link $active' href='/?p=$p'>$label</a></li>";
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Mini Burp Lab</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="/assets/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">Mini Burp Lab</a>
    <ul class="navbar-nav ms-auto">
      <?php nav_link('home','Home'); nav_link('about','About'); nav_link('contact','Contact'); nav_link('docs','Docs'); nav_link('secret','Secret'); ?>
    </ul>
  </div>
</nav>

<main class="container my-4">
<?php if($p === 'home'): ?>
  <h1>Bienvenido</h1>
  <p>Pequeña web para enseñar intercepting proxies y XSS.</p>
  <p>
    - ¿Qué le dice un Bit al otro?<br>
    - Nos vemos en el bus
</p><p>
    - ¿En qué se parecen Batman y Microsoft?<br>
    - En que ambos luchan contra el pingüino
</p><p>
    - Solo hay 10 tipos de persona, las que saben binario y las que no.
</p><p>
    - ¿Cual es la mejor forma de acelerar un PC?<br>
    - 9.8 m/s2
</p><p>
    - ¿Qué le dice una IP a otra?<br>
    - ¿Qué tramas?
</p><p>
    - ¿Qué son 8 hobbits?<br>
    - Un hobyte.
</p><p>
    - Te contaría un chiste sobre UDP, pero puede que no lo pilles.
</p><p>
    - Error, no hay teclado.<br>
    - Pulse F1 para continuar.
</p><p>
    - El optimista: El vaso está medio completo.<br>
    - El pesimista: El vaso está medio vacío.<br>
    - El informático: El vaso es dos veces más grande de lo necesario.
</p><p>
    - ¿Por qué se ha enfriado el ordenador?<br>
    - Porque se le ha olvidado cerrar ventanas.
</p><p>
    - ¿Qué tipo de médico es el que arregla páginas web?<br>
    - El URLologo.
</p><p>
<?php elseif($p === 'about'): ?>
  <h1>About</h1>
  <p>Bienvenido al laboratorio del módulo de <strong>Hacking Ético</strong> del <strong>IES Celia Viñas</strong>, Almería. Este espacio ha sido creado para que el alumnado del curso de especialización en ciberseguridad practique de forma segura técnicas de análisis de aplicaciones web, uso de proxies/interceptores, pruebas de inyección y detección de malas configuraciones.</p>
<p>Todas las prácticas se realizan en entornos controlados y con fines didácticos: el objetivo es formar profesionales responsables capaces de identificar riesgos y proponer medidas de mitigación conforme a la ley y a las buenas prácticas del sector.</p>

<?php elseif($p === 'docs'): ?>
  <h1>Docs</h1>
  <p>Explore alguno de los documentos claves de este sitio. </p>
  <article>
    <h4>Guía rápida</h4>
    <p>The path of the righteous man is beset on all sides by the iniquities of the selfish and the tyranny of evil men. Blessed is he who, in the name of charity and good will, shepherds the weak through the valley of darkness, for he is truly his brother's keeper and the finder of lost children. And I will strike down upon thee with great vengeance and furious anger those who would attempt to poison and destroy My brothers. And you will know My name is the Lord when I lay My vengeance upon thee.</p>

    <p>Your bones don't break, mine do. That's clear. Your cells react to bacteria and viruses differently than mine. You don't get sick, I do. That's also clear. But for some reason, you and I react the exact same way to water. We swallow it too fast, we choke. We get some in our lungs, we drown. However unreal it may seem, we are connected, you and I. We're on the same curve, just on opposite ends.</p>
  </article>

<?php elseif($p === 'contact'): ?>
  <h1>Contact</h1>
  <p>Envía un email y una petición. Atención: la protección está en cliente (JS) únicamente.</p>

  <form id="contactForm" method="post" action="/submit.php">
    <div class="mb-3">
      <label class="form-label">Email</label>
      <input required name="email" id="email" type="email" class="form-control" placeholder="tu@ejemplo.com">
    </div>
    <div class="mb-3">
      <label class="form-label">Petición</label>
      <textarea required name="message" id="message" class="form-control" rows="4"></textarea>
    </div>
    <button class="btn btn-primary" type="submit">Enviar</button>
    <small class="text-muted ms-2">(Protección por JS: escapar &lt; &gt; — se puede evitar con Burp)</small>
  </form>

  <script>
  // *Protección solo en cliente* (fácil de desactivar)
  function sanitize(s){
    return s.replace(/</g,'&lt;').replace(/>/g,'&gt;');
  }
  document.getElementById('contactForm').addEventListener('submit', function(e){
    // sustituimos los valores en el form por versiones escapadas
    document.getElementById('email').value = sanitize(document.getElementById('email').value);
    document.getElementById('message').value = sanitize(document.getElementById('message').value);
    // formulario se envía normalmente con los valores sanitizados
  });
  </script>

<?php elseif($p === 'secret'): ?>
  <h1>Secret area</h1>
  <p>Esta sección hace una petición oculta en background a un endpoint.</p>

  <p>Trucos: mira el sitemap de Burp o las peticiones XHR para ver la llamada a <code>/hidden_flag.php</code>.</p>

  <div id="hidden-holder" style="display:none"></div>

  <script>
  // Petición oculta lanzada al cargar esta sección:
  fetch('/hidden_flag.php').then(resp=>resp.text()).then(t=>{
    // la respuesta NO se muestra inband; la guardamos en un div oculto y en consola
    document.getElementById('hidden-holder').textContent = t;
    console.log('hidden flag response received (hidden)');
  }).catch(()=>{ console.log('no hidden flag'); });
  </script>

<?php else: ?>
  <h1>404</h1>
<?php endif; ?>
</main>

<footer class="text-center py-3">
  <small>Mini Burp Lab — solo para prácticas en entorno controlado.@copy; IES Celia Viñas</small>
</footer>
</body>
</html>
