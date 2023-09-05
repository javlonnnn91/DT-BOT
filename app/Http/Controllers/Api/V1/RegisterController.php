<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRegisterRequest;
use App\Http\Requests\UpdateRegisterRequest;
use App\Models\Register;

class RegisterController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRegisterRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRegisterRequest $request): \Illuminate\Http\Response|bool
    {
        $phone_number = $request->input(['phone_number']);
        $registers = Register::query()->where('phone_number', $phone_number)->first();
        if(!$registers)
            $registers = new Register();

        $registers->phone_number = $phone_number;

        return $registers->save() ?? false;
    }
}
