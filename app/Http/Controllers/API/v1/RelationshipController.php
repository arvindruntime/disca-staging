<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\RelationshipModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\v1\BaseController;
use Illuminate\Support\Facades\Auth;

class RelationshipController extends BaseController
{
    public function index()
    {
        try {
            $relationship = RelationshipModel::all();
            if (!empty($relationship)) {
                return $this->sendResponse($relationship, 'Relationship listed successfully.', 200);
            } else {
                return $this->sendError('Relationship not found.', [], 402);
            }
        } catch (\Throwable $th) {
            return $this->sendError('Error.', ['error' => $th->getMessage()], 402);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $relationship = RelationshipModel::find($id);
            if (!empty($relationship)) {
                return $this->sendResponse($relationship, 'Relationship fetched successfully.', 200);
            } else {
                return $this->sendError('Relationship not found.', [], 402);
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
            
            $relationship = new RelationshipModel();
            $relationship->user_id = Auth::user()->id;
            $relationship->name = $request->name;
            $relationship->save();

            return $this->sendResponse([], 'Relationship Created Successfully.', 200);
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
            
            $relationship = RelationshipModel::find($id);
            $relationship->user_id = Auth::user()->id;
            $relationship->name = $request->name;
            $relationship->save();

            return $this->sendResponse([], 'Relationship Updated Successfully.', 200);
        } catch (\Exception $th) {
            return $this->sendError('Error.', ['error' => $th->getMessage()], 402);
        }
    }

    public function destroy($id)
    {
        try {
            $relationship = RelationshipModel::find($id);
            if (!empty($relationship)) {
                $relationship->delete();
                return $this->sendResponse([], 'Relationship delete Successfully.', 200);
            } else {
                return $this->sendError('Invalid Relationship id provided', [], 402);
            }
        } catch (\Throwable $th) {
            return $this->sendError('Error.', ['error' => $th->getMessage()], 402);
        }
    }
}
