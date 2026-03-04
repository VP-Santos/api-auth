<?php

$url = env('APP_URL', 'http://localhost:8080');
return [
    'reset' => $url . '/reset',
    'verifyEmail' => $url . '/verify-email'
];
