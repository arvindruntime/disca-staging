<?php

namespace App\Http\Controllers;

use Log;
use App\Models\Board;
use App\Models\WebSitePage;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        try {
            $boardTopics = Board::all();
            $pages = WebSitePage::all();
            view()->share(['pages' => $pages, "boardTopics" => $boardTopics]);
        } catch (Exception $e) {
            Log::error('Error in sharing data to views: ' . $e->getMessage());
        }
    }
}
