<?php
namespace App\Exceptions\Capsule;

use Exception;
use Illuminate\Http\Request;

class CapsuleException extends Exception
{

    public function render(Request $request)
    {
        return response()->json([
            'error' => [$this->getMessage()]
        ], 500);
    }
}
