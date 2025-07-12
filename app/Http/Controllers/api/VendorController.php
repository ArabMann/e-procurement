<?php

namespace App\Http\Controllers\api;

use App\Models\Vendor;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\VendorResource;
use App\Http\Requests\StoreVendorRequest;

class VendorController extends Controller
{
    //
    public function store(StoreVendorRequest $request){
        $response = DB::transaction(function () use($request) {
            $validation = $request->validated();
            $user = Auth::user()->id;

            $validation["user_id"] = $user;
            $validation["slug"] = Str::slug($validation["name"]);

            $storeVendor = Vendor::create($validation);

            return (new VendorResource($storeVendor))->additional([
                "success" => true,
                "message" => "Vendor Berhasil Dibuat",
            ]);
        });

        return $response;
    }
}
