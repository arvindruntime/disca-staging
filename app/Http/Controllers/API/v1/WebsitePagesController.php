<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\WebSitePage;
use App\Services\WebsitePageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WebsitePagesController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $perPage = $request->query('per_page', 10);
            $pages = WebSitePage::paginate($perPage);
            if (!empty($pages)) {
                return $this->sendResponse($pages, 'Pages retrieved successfully.', 200);
            } else {
                return $this->sendError('Pages not found.', [], 402);
            }
        } catch (\Throwable $th) {
            return $this->sendError('Error.', ['error' => $th->getMessage()], 402);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $slug = null)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'content' => 'required',
                'permalink' => 'required' . isset($slug) ? '' : "|unique:web_site_pages,permalink",
            ], [
                'title' => 'Please enter page title',
                'content' => 'Please enter content of the page',
                "permalink.required" => 'Please enter permalink of the page',
                "permalink.unique" => 'Link already in use, Please enter different permalink',
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
            $page = isset($slug) ? WebSitePage::where('permalink', $slug)->first() : new WebSitePage;
            $page = WebsitePageService::createUpdate($page, $request);
            return $this->sendResponse($page, 'Page Created Successfully.', 200);
        } catch (\Exception $e) {
            return $this->sendError('Error.', ['error' => $e->getMessage()], 402);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $slug)
    {
        try {
            $page = WebSitePage::where('permalink', $slug)->first();
            if (!empty($page)) {
                return $this->sendResponse($page, 'Page fetched successfully.', 200);
            } else {
                return $this->sendError('Page not found.', [], 402);
            }
        } catch (\Throwable $th) {
            return $this->sendError('Error.', ['error' => $th->getMessage()], 402);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        try {
            $page = WebSitePage::where('permalink', $slug);
            if (!empty($page)) {
                WebSitePage::where(['permalink' => $slug])->delete();
                return $this->sendResponse([], 'Page deleted Successfully.', 200);
            } else {
                return $this->sendError('Invalid page id provided', [], 402);
            }
        } catch (\Throwable $th) {
            return $this->sendError('Error.', ['error' => $th->getMessage()], 402);
        }
    }
}
