<?php
// Este script refleja los parámetros tal cual (sin htmlspecialchars): VULNERABLE a reflected XSS
// FLAG cuando se logra ejecutar XSS (simulado: la página incluye una DIV con el flag si detecta <script> en el message)
$email = $_POST['email'] ?? '';
$message = $_POST['message'] ?? '';

// Aquí NO sanitizamos a posta, para la práctica
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Resultado envío</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container my-4">
  <h1>Envío recibido</h1>
  <p><strong>Email:</strong> <?= $email ?></p>
  <p><strong>Mensaje:</strong></p>
  <div class="p-3 border"><?= $message ?></div>

  <?php
  // mecanismo simple para devolver una flag visible en la propia página si la carga contiene <script>
  // Es solo para la práctica: Si el message contiene la cadena "<script" mostramos una flag adicional
  if (stripos($message, '<script') !== false) {
      echo "<div class='alert alert-success mt-3'><strong>FLAG:</strong> FLAG{XSS_REFLECTED_1234}</div>";
  }
  ?>

  <p class="mt-3"><a href="/?p=contact" class="btn btn-secondary">Volver</a></p>
</body>
</html>
