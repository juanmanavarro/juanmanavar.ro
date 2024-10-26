<?php
function getColor($tag) {
    $hash = 0;
    for ($i = 0; $i < strlen($tag); $i++) {
        $hash = ord($tag[$i]) + (($hash << 5) - $hash);
    }
    $color = '#';
    for ($i = 0; $i < 3; $i++) {
        $value = ($hash >> ($i * 8)) & 0xFF;
        $color .= str_pad(dechex($value), 2, "0", STR_PAD_LEFT);
    }
    return $color;
}

function readEnv($clave) {
    $ruta = __DIR__ . '/.env';
    if (file_exists($ruta)) {
        $contenido = file_get_contents($ruta);
        $lineas = explode("\n", $contenido);
        foreach ($lineas as $linea) {
            list($k, $v) = explode('=', $linea, 2) + [NULL, NULL];
            if ($k === $clave) {
                return trim($v);
            }
        }
    }
    return getenv($clave);
}

$url = readEnv('API_URL') . '?where=(active,eq,1)&shuffle=1';
$token = readEnv('API_TOKEN');

$options = [
    'http' => [
        'header' => "xc-token: $token\r\n"
    ]
];

$context = stream_context_create($options);
$response = file_get_contents($url, false, $context);

if ($response === FALSE) {
    $jobs = [];
} else {
    $data = json_decode($response, true);
    $jobs = $data['list'] ?? [];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Juanma Navarro | Programador Autónomo</title>
    <meta name="description" content="Juanma Navarro | Programador Autónomo">
    <link href="https://bootswatch.com/5/cosmo/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, width=device-width">
    <link rel="icon" href="./favicon.jpg">
    <script defer data-domain="<?php echo readEnv('SITE_DOMAIN'); ?>" src="https://analytics.juanma.app/js/script.js"></script>
</head>
<body data-bs-theme="dark">
    <div class="container-fluid">
        <header class="text-center py-3 fixed-top bg-dark">
            <h1>Juanma Navarro</h1>
            <p>Programador Autónomo</p>
            <ul class="list-unstyled list-inline">
                <li class="list-inline-item"><a class="text-decoration-none" href="https://github.com/juanmanavarro" target="_blank">GITHUB</a></li>
                <li class="list-inline-item"><a class="text-decoration-none" href="https://telegram.me/juanmanavarro" target="_blank">TELEGRAM</a></li>
                <li class="list-inline-item"><a class="text-decoration-none" href="https://api.whatsapp.com/send?phone=34613086944" target="_blank">WHATSAPP</a></li>
                <li class="list-inline-item"><a class="text-decoration-none" href="https://www.linkedin.com/in/juanmanavarro/" target="_blank">LINKEDIN</a></li>
                <li class="list-inline-item"><a class="text-decoration-none" rel="nofollow" href="mailto:hola@juanmanavar.ro">EMAIL</a></li>
                <li class="list-inline-item"><a class="text-decoration-none" href="tel:+34613086944">TELÉFONO</a></li>
            </ul>
        </header>
        <main style="margin: 180px 0 120px;">
            <section class="p-0 p-sm-3">
                <div class="row">
                    <?php foreach ($jobs as $job): ?>
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
                            <div class="card bg-dark" style="cursor: pointer; border-radius: 10px;">
                                <div style="border-top-left-radius: 10px; border-top-right-radius: 10px; height: 250px; background-image: url('https://nocodb.juanma.app/<?php echo $job['image'][0]['thumbnails']['card_cover']['signedPath']; ?>'); background-size: cover; background-position: top;">
                                </div>
                                <div class="p-4 border-top">
                                    <h3 class="mb-3"><?php echo htmlspecialchars($job['Title']); ?></h3>
                                    <p class="mb-3"><?php echo htmlspecialchars($job['description']); ?></p>
                                    <?php if (!empty($job['tags'])): ?>
                                        <div>
                                            <?php foreach (explode(',', $job['tags']) as $tag): ?>
                                                <?php $tag = trim($tag); ?>
                                                <span style="background-color: <?php echo getColor($tag); ?>;" class="badge me-1 mb-1"><?php echo htmlspecialchars($tag); ?></span>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        </main>
        <footer class="text-center p-5 fixed-bottom bg-dark">
            <ul class="list-unstyled list-inline mb-0">
                <li class="list-inline-item"><a class="text-decoration-none" href="https://github.com/juanmanavarro" target="_blank">GITHUB</a></li>
                <li class="list-inline-item"><a class="text-decoration-none" href="https://telegram.me/juanmanavarro" target="_blank">TELEGRAM</a></li>
                <li class="list-inline-item"><a class="text-decoration-none" href="https://api.whatsapp.com/send?phone=34613086944" target="_blank">WHATSAPP</a></li>
                <li class="list-inline-item"><a class="text-decoration-none" href="https://www.linkedin.com/in/juanmanavarro/" target="_blank">LINKEDIN</a></li>
                <li class="list-inline-item"><a class="text-decoration-none" rel="nofollow" href="mailto:hola@juanmanavar.ro">EMAIL</a></li>
                <li class="list-inline-item"><a class="text-decoration-none" href="tel:+34613086944">TELÉFONO</a></li>
            </ul>
        </footer>
    </div>
</body>
</html>
