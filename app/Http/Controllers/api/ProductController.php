<?php

namespace App\Http\Controllers\api;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    //
    public function index($id)
    {
        $products = Product::where("vendor_id", $id)->get();

        return (ProductResource::collection($products))->additional([
            "success" => true,
            "message" => "Data Product Sesuai Vendor Telah Ditampilkan"
        ]);
    }

    public function store(StoreProductRequest $request)
    {
        $response = DB::transaction(function () use ($request) {
            $user = Auth::user();
            $validation = $request->validated();

            // Ambil vendor_id dari input
            $vendorId = $validation['vendor_id'];

            // Pastikan vendor ini milik user
            if (!$user->vendors()->where('id', $vendorId)->exists()) {
                return response()->json([
                    "success" => false,
                    "message" => "Vendor ini bukan milikmu!"
                ], 403);
            }

            // Tambah slug
            $validation["slug"] = Str::slug($validation["name"]);

            // Simpan product
            $productStore = Product::create($validation);

            return (new ProductResource($productStore))->additional([
                "success" => true,
                "message" => "Data Product Berhasil Ditambahkan",
            ]);
        });

        return $response;
    }


    public function update(UpdateProductRequest $request, Product $product)
    {
        $response = DB::transaction(function () use ($request, $product) {
            $validation = $request->validated();
            $user = Auth::user();

            // Ambil semua ID vendor milik user
            $vendorIds = $user->vendors()->pluck('id')->toArray();

            // Cek apakah product ini bukan milik salah satu vendor user
            if (!in_array($product->vendor_id, $vendorIds)) {
                return response()->json([
                    "success" => false,
                    "message" => "Kamu Bukan Pemilik Product Ini"
                ], 403);
            }

            // Update slug dan simpan
            $validation["slug"] = Str::slug($validation["name"]);
            $product->update($validation);

            return (new ProductResource($product))->additional([
                "success" => true,
                "message" => "Data Product Berhasil Di Update"
            ]);
        });

        return $response;
    }

    public function destroy(Product $product)
    {
        $user = Auth::user();

        DB::beginTransaction();
        try {
            // Ambil semua vendor_id milik user
            $userVendorIds = $user->vendors()->pluck('id')->toArray();

            // Cek apakah produk ini milik salah satu vendor user
            if (!in_array($product->vendor_id, $userVendorIds)) {
                return response()->json([
                    "success" => false,
                    "message" => "Product ini bukan milikmu!"
                ], 403);
            }

            $product->delete();
            DB::commit();

            return response()->json([
                "success" => true,
                "message" => "Data Berhasil Dihapus"
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                "success" => false,
                "message" => "Data Gagal Dihapus",
                "error" => $e->getMessage() // bisa dihapus di production
            ], 500);
        }
    }
}
