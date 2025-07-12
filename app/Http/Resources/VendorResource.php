<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VendorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function user($user_id)
    {
        $user = User::findOrFail($user_id);
        return [
            "id" => $user->id,
            "name" => $user->name
        ];
    }
    public function toArray(Request $request): array
    {
        return [
            "name" => $this->name,
            "address" => $this->address,
            "number_phone" => $this->number_phone,
            "slug" => $this->slug,
            "user" => $this->user($this->user_id),
        ];
    }
}
