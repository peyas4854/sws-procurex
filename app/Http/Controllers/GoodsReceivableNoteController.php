<?php

namespace App\Http\Controllers;

use App\Services\GoodsReceivableNoteService;
use Illuminate\Http\Request;

class GoodsReceivableNoteController extends Controller
{
    protected $goodsReceivableNoteService;

    public function __construct(GoodsReceivableNoteService $goodsReceivableNoteService)
    {
        $this->goodsReceivableNoteService = $goodsReceivableNoteService;
        $this->middleware('permission:grn-list', ['only' => ['index']]);
        $this->middleware('permission:grn-create', ['only' => ['create']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();
        $grns = $this->goodsReceivableNoteService->lists($data);
        $search = $request->search;

        return view('goods-receivable-note.list',compact('grns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('goods-receivable-note.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
