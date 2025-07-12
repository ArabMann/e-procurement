<?php

namespace App\Http\Resources;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function role($role_id)
    {
        $role = Role::findOrFail($role_id);
        return [
            "id" => $role->id,
            "name" => $role->name,
        ];
    }
    
    public function toArray(Request $request): array
    {

        return [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "role" => $this->role($this->role_id),
        ];
    }
}
