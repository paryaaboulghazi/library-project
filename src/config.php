<?php

return [
    'github' => [
        'base_uri' => $_ENV['GITHUB_BASE_URI'] ?? 'https://api.github.com/',
        'personal_access_token' => $_ENV['GITHUB_PERSONAL_ACCESS_TOKEN'] ?? 'default-token',
    ],
];
