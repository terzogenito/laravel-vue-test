<?php

return [
    'paths' => ['api/*'], // Enable CORS for API endpoints
    'allowed_methods' => ['*'], // Allow all HTTP methods (GET, POST, PUT, etc.)
    // 'allowed_origins' => ['*'],
    'allowed_origins' => ['http://localhost:5173'], // Add your Vue development server origin
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'], // Allow all headers
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,
];