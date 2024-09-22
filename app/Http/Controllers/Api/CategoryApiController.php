<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryApiController extends Controller
{
    // Get All Categories
    public function index(Request $request)
    {
        $categories = Category::all();
        $msg = 'Get All Category Success.';

        return $this->sendResponse(CategoryResource::collection($categories), $msg);
    }
}
