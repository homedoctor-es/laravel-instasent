<?php

return [
    /*
      |--------------------------------------------------------------------------
      | Api Key
      |--------------------------------------------------------------------------
      |
      | The Instasent API token.
     */
    'api_token' => env('INSTASENT_API_TOKEN'),
    /*
      |--------------------------------------------------------------------------
      | Default From
      |--------------------------------------------------------------------------
      |
      | Default remitent of the SMS messages.
     */
    'default_from' => env('INSTASENT_DEFAULT_FROM', 'Laravel'),
    /*
      |--------------------------------------------------------------------------
      | Dry Run
      |--------------------------------------------------------------------------
      |
      | Instasent Dry Run
     */
    'dry_run' => (bool) env('INSTASENT_DRY_RUN', false),
    /*
      |--------------------------------------------------------------------------
      | Throw Exception on Error
      |--------------------------------------------------------------------------
      |
      | Throws or not an exception on an API error.
     */
    'throw_exception_on_error' => (bool) env('INSTASENT_THROW_EXCEPTION_ON_ERROR', false),
];
