<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register() {
    
        $this->renderable( function ( ValidationException $ex, $request ) {
            
            $response = [
                'ErrorCode' => 'my_error_code',
                'ErrorMessage' => $ex->validator->errors()
            ];
            
            return response()->json( $response );
        } );
    }
}
