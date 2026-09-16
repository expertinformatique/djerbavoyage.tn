<?php
return [
    'secret_key'      => $_ENV['STRIPE_SECRET_KEY'] ?? 'sk_test_dummy',
    'publishable_key' => $_ENV['STRIPE_PUB_KEY'] ?? 'pk_test_dummy',
    'webhook_secret'  => $_ENV['STRIPE_WEBHOOK_SECRET'] ?? 'whsec_sample_webhook_secret_999',
    'currency'        => 'eur',
];
