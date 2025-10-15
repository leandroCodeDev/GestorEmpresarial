<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    /*
|--------------------------------------------------------------------------
| CORS Paths
|--------------------------------------------------------------------------
|
| Quais rotas devem aplicar CORS. Geralmente se limita a rotas de API.
|
*/
    'paths' => explode(',', env('CORS_PATHS', 'api/*,sanctum/csrf-cookie')),

    /*
    |--------------------------------------------------------------------------
    | Allowed Methods
    |--------------------------------------------------------------------------
    |
    | Métodos HTTP permitidos. ['*'] libera todos.
    |
    */
    'allowed_methods' => explode(',', env('CORS_ALLOWED_METHODS', '*')),

    /*
    |--------------------------------------------------------------------------
    | Allowed Origins
    |--------------------------------------------------------------------------
    |
    | Use '*' para todas as origens (sem suporte a cookies), ou defina origens específicas.
    | Use explode(',', env('ALLOWED_ORIGINS')) para gerenciar via .env.
    |
    */
    'allowed_origins' => array_map('trim', explode(',', env('ALLOWED_ORIGINS', '*'))),

    /*
    |--------------------------------------------------------------------------
    | Allowed Origins Patterns
    |--------------------------------------------------------------------------
    |
    | Útil para regex. Ex: ['^https://.*\.example\.com$']
    |
    */
    'allowed_origins_patterns' => array_filter(explode(',', env('CORS_ALLOWED_ORIGINS_PATTERNS', ''))),

    /*
    |--------------------------------------------------------------------------
    | Allowed Headers
    |--------------------------------------------------------------------------
    |
    | Cabeçalhos HTTP aceitos. ['*'] permite todos.
    |
    */
    'allowed_headers' => explode(',', env('CORS_ALLOWED_HEADERS', '*')),

    /*
    |--------------------------------------------------------------------------
    | Exposed Headers
    |--------------------------------------------------------------------------
    |
    | Cabeçalhos que o browser pode acessar diretamente.
    |
    */
    'exposed_headers' => array_filter(explode(',', env('CORS_EXPOSED_HEADERS', ''))),

    /*
    |--------------------------------------------------------------------------
    | Max Age
    |--------------------------------------------------------------------------
    |
    | Tempo (em segundos) que o browser pode cachear a resposta CORS (preflight).
    |
    */
    'max_age' => (int) env('CORS_MAX_AGE', 0),

    /*
    |--------------------------------------------------------------------------
    | Supports Credentials
    |--------------------------------------------------------------------------
    |
    | Define se cookies/autenticação devem ser enviados com as requisições.
    | Se `true`, você NÃO pode usar `allowed_origins = ['*']`.
    |
    */
    'supports_credentials' => filter_var(env('CORS_SUPPORTS_CREDENTIALS', false), FILTER_VALIDATE_BOOL),

];
