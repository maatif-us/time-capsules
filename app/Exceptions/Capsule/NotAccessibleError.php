<?php 
namespace App\Exceptions\Capsule;


use Illuminate\Http\Request;

class NotAccessibleError extends CapsuleException
{
    public function render(Request $request)
    {

        return response()->json([
            'error' => [$this->getMessage() ?? 'Resource not accessible.']
        ], 400);
    }
}