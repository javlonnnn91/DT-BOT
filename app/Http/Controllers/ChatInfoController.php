<?php

namespace App\Http\Controllers;

use App\Models\ChatInfo;
use App\Http\Requests\StoreChatInfoRequest;
use App\Http\Requests\UpdateChatInfoRequest;

class ChatInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreChatInfoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreChatInfoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ChatInfo  $chatInfo
     * @return \Illuminate\Http\Response
     */
    public function show(ChatInfo $chatInfo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ChatInfo  $chatInfo
     * @return \Illuminate\Http\Response
     */
    public function edit(ChatInfo $chatInfo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateChatInfoRequest  $request
     * @param  \App\Models\ChatInfo  $chatInfo
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateChatInfoRequest $request, ChatInfo $chatInfo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ChatInfo  $chatInfo
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChatInfo $chatInfo)
    {
        //
    }
}
