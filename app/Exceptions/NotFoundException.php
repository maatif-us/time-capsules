<?php 
namespace App\Exceptions;

use Exception;

class NotFoundException extends Exception 
{
   
    public function render()
    {
        return response()->json([
            'error' => [$this->getMessage() ?? 'Resource not found!']
        ], 404);
    }
}