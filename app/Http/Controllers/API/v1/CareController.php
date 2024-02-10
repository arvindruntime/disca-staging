<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Care;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\v1\BaseController;
use Illuminate\Support\Facades\Auth;

class CareController extends BaseController
{
    public function index()
    {
        try {
            $care = Care::all();
            if (!empty($care)) {
                return $this->sendResponse($care, 'Care listed successfully.', 200);
            } else {
                return $this->sendError('Care not found.', [], 402);
            }
        } catch (\Throwable $th) {
            return $this->sendError('Error.', ['error' => $th->getMessage()], 402);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $care = Care::find($id);
            if (!empty($care)) {
                return $this->sendResponse($care, 'Care fetched successfully.', 200);
            } else {
                return $this->sendError('Care not found.', [], 402);
            }
        } catch (\Throwable $th) {
            return $this->sendError('Error.', ['error' => $th->getMessage()], 402);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
            ], [
                'name.required' => 'Please enter the name',
            ]);

            if ($validator->fails()) {
                if ($request->is('api/*')) {
                    return response()->json(
                        [
                            'status' => 402,
                            'statusState' => 'error',
                            'message' => (empty($validator->errors()) ? 'Something went wrong' : $validator->errors())->first(),
                        ],
                        402
                    );
                } else {
                    return response()->json(['error' => $validator->errors()->all()]);
                }
            }
            
            $care = new Care();
            $care->user_id = Auth::user()->id;
            $care->name = $request->name;
            $care->save();

            return $this->sendResponse([], 'Care Created Successfully.', 200);
        } catch (\Exception $th) {
            return $this->sendError('Error.', ['error' => $th->getMessage()], 402);
        }
    }

    public function Update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
            ], [
                'name.required' => 'Please enter the name',
            ]);

            if ($validator->fails()) {
                if ($request->is('api/*')) {
                    return response()->json(
                        [
                            'status' => 402,
                            'statusState' => 'error',
                            'message' => (empty($validator->errors()) ? 'Something went wrong' : $validator->errors())->first(),
                        ],
                        402
                    );
                } else {
                    return response()->json(['error' => $validator->errors()->all()]);
                }
            }
            
            $care = Care::find($id);
            $care->user_id = Auth::user()->id;
            $care->name = $request->name;
            $care->save();

            return $this->sendResponse([], 'Care Updated Successfully.', 200);
        } catch (\Exception $th) {
            return $this->sendError('Error.', ['error' => $th->getMessage()], 402);
        }
    }

    public function destroy($id)
    {
        try {
            $Care = Care::find($id);
            if (!empty($Care)) {
                $Care->delete();
                return $this->sendResponse([], 'Care delete Successfully.', 200);
            } else {
                return $this->sendError('Invalid Care id provided', [], 402);
            }
        } catch (\Throwable $th) {
            return $this->sendError('Error.', ['error' => $th->getMessage()], 402);
        }
    }
}
