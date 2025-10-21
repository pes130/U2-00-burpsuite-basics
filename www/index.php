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

<?php elseif($p === 'about'): ?>
  <h1>About</h1>
  <p>Esto es demo: contiene varias secciones para que el sitemap tenga "chicha".</p>

  <h3>Sitemap (simulado)</h3>
  <ul>
    <li>/</li>
    <li>/?p=about</li>
    <li>/?p=docs</li>
    <li>/?p=contact</li>
    <!-- Note: no /hidden_flag.php ni /submit.php links -->
  </ul>

<?php elseif($p === 'docs'): ?>
  <h1>Docs</h1>
  <p>Algunas entradas de documentación de ejemplo para dar contenido al sitemap.</p>
  <article>
    <h4>Guía rápida</h4>
    <p>Este es contenido estático que facilita que el spider de Burp tenga páginas que indexar.</p>
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
  <p>Esta sección hace una petición oculta (background) a un endpoint no linked que devuelve una flag — no se muestra en la UI.</p>

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
  <small>Mini Burp Lab — solo para prácticas en entorno controlado</small>
</footer>
</body>
</html>
