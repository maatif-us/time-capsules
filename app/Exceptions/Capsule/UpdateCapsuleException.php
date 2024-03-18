<?php 
namespace App\Exceptions\Capsule;


use Illuminate\Http\Request;

class UpdateCapsuleException extends CapsuleException
{
    public function render(Request $request)
    {

        return response()->json([
            'error' => [$this->getMessage() ?? 'Unable to update Capsule.']
        ], 406);
    }
}