<?php

namespace App\Http\Controllers\Api;

use App\Mail\VerifyNumberCreated;
use App\Mail\VerifyNumbers\create;
use App\VerifyNumber;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class VerifyNumberController extends ApiController
{
    public function store(Request $request)
    {
        $request->validate([
           "email" => "required|email|unique:users",
        ]);

        $verifyNumber = VerifyNumber::updateOrCreate([
            "email" => $request->email
        ],[
            "email" => $request->email,
            "number" => random_int(1000,9999)
        ]);

        Mail::to($request->email)->send(new VerifyNumberCreated($verifyNumber));

        return $this->respondSuccessfully($verifyNumber, __("response.verifyNumber")["send mail"]);
    }

    public function show($id)
    {
        //
    }


    public function update(Request $request, VerifyNumber $verifyNumber)
    {
        if(!$verifyNumber)
            return $this->respondNotFound();

        if($verifyNumber->number != $request->number)
            return $this->respondImproperCondition(__("response.verifyNumber")["do not match"]);

        $verifyNumber->update([
            "verified" => true
        ]);

        return $this->respondSuccessfully($verifyNumber, __("response.verifyNumber")["verified"]);
    }

    public function destroy($id)
    {
        //
    }
}
