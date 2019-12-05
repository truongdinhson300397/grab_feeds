<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateItemRequest;
use App\Http\Requests\FilterCategoryRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the events.
     *
     * @return Item
     */
    public function shows(Item $event)
    {
        return $event;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Item
     */

    public function index(FilterCategoryRequest $request)
    {
        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'desc');
        $search = $request->get('search', '');
        $items = Item::orderBy($sort, $direction);
        if (isset($search)) {
            $items = $items->where('title', 'like', '%' . $search . '%');
        }
        $items = $items->paginate(10);
        return view('admins.items.index', [
            'items' => $items->appends($request->except('page'))
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admins.items.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateItemRequest $request)
    {
        $item = new Item();
        $item->fill($request->validated());
        $item->save();
        return redirect()->route('items.index')->with('status', 'Create item success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        return view('admins.items.show', ['item' => $item]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        return view('admins.items.edit', ['item' => $item]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateItemRequest $request, Item $item)
    {
        $item->fill($request->validated())->save();
        return redirect()->route('items.show', $item->id)->with('status', 'Item updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $item->delete();
        return redirect()->route('items.index')->with('status', 'Item deleted');
    }
}
