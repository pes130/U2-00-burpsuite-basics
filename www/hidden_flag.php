<?php
// Endpoint no enlazado en el sitemap HTML (solo llamado por la sección secret vía JS XHR).
// Devuelve la flag; la UI no la muestra (solo console/hidden div) para forzar a mirar Burp.
header('Content-Type: text/plain');
echo "FLAG{SITEMAP_DISCOVERY_4321}";
