<?php

namespace App\Http\Controllers\API\v1;

use App\Models\CmsPage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CmsPageController extends Controller
{
    public function cmsPages(Request $request)
    {
        try {
            $pageType = $request->type;
            $cmsPages = CmsPage::where('type', $pageType)->first();
            if($pageType == 'privacy_policy') {
                $message = 'Privacy Policy fetched successfully';
            } else if($pageType == 'cookie_policy') {
                $message = 'Cookie Policy fetched successfully';
            } else if($pageType == 'terms_and_condition') {
                $message = 'Terms of Service fetched successfully';
            }
            return sendResponse($cmsPages, $message);
        } catch (\Throwable $th) {
            return sendError('Error Occurred');
        }
    }
}
