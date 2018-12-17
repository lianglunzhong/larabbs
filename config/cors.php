<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel CORS
    |--------------------------------------------------------------------------
    |
    | allowedOrigins, allowedHeaders and allowedMethods can be set to array('*')
    | to accept any value.
    |
    */
    // 是否携带 Cookie Access-Control-Allow-Credentials
    'supportsCredentials' => false,
    // 允许的域名 Access-Control-Allow-Origin
    'allowedOrigins' => ['*'],
    // 通过正则匹配允许的域名 Access-Control-Allow-Origin
    'allowedOriginsPatterns' => [],
    // 允许的 Header Access-Control-Allow-Headers
    'allowedHeaders' => ['*'],
    // 允许的 HTTP 方法 Access-Control-Allow-Methods
    'allowedMethods' => ['*'],
    // 除了 6 个基本的头字段，额外允许的字段 Access-Control-Expose-Headers
    'exposedHeaders' => [],
    // 预检请求的有效期 Access-Control-Max-Age
    'maxAge' => 0,

];
