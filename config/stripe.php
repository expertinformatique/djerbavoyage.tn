<?php
return [
    'secret_key'      => getenv('STRIPE_SECRET_KEY') ?: ($_ENV['STRIPE_SECRET_KEY'] ?? ''),
    'publishable_key' => getenv('STRIPE_PUB_KEY') ?: ($_ENV['STRIPE_PUB_KEY'] ?? ''),
    'webhook_secret'  => getenv('STRIPE_WEBHOOK_SECRET') ?: ($_ENV['STRIPE_WEBHOOK_SECRET'] ?? ''),
    'currency'        => 'eur',
];
