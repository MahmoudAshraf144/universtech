<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return
        [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'national_id' => $this->nationalid,
            'gender' => $this->gender==0 ? "Male" : "Female",
            'phone' => $this->phone,
            'credit_points' => $this->credit_points,
            'semester' => $this->semester,
            'admin' => $this->admin->name,
            'department' =>
            [
                'id' => $this->department->id,
                'name' => $this->department->name,
            ],
            'level' =>
            [
                'id' => $this->level->id,
                'name' => $this->level->name,
            ],
        ];
    }
}
