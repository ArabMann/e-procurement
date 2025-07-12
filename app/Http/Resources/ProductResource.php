<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function category($category_id)
    {
        $category = Category::findOrFail($category_id);
        return [
            "id" => $category->id,
            "name" => $category->name,
        ];
    }
    public function vendor($vendor_id)
    {
        $vendor = Vendor::findOrFail($vendor_id);
        return [
            "id" => $vendor->id,
            "name" => $vendor->name,
        ];
    }
    public function toArray(Request $request): array
    {
        return [
            "name" => $this->name,
            "description" => $this->description,
            "slug" => $this->slug,
            "category" => $this->category($this->category_id),
            "vendor" => $this->vendor($this->vendor_id),
        ];
    }
}
