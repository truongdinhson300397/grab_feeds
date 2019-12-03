<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Http\Requests\FilterCategoryRequest;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryItemController extends Controller
{
    public function index()
    {
//        $sort = $request->get('sort', 'id');
//        $direction = $request->get('direction', 'desc');
//        $search = $request->get('search', '');
//        $category_items = Category::items()->orderBy($sort, $direction);
//        if (isset($search)) {
//            $category_items = $category_items->where('category_id', 'like', '%' . $search . '%');
//        }
        $category_items = DB::table('category_item')->get();
        return view('admins.category-item.index', [
            'category_items' => $category_items
        ]);
    }

    public  function destroy($id){
        DB::table('category_item')->delete($id);
        return redirect()->route('category-item.index')->with('status', 'Category item deleted');
    }
}
