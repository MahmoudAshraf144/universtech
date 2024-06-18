<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CoursesResource extends JsonResource
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
            'id'=> $this->id,
            'course_id' => $this->course->id,
            'course_name' => $this->course->course_name,
            'course_code' => $this->course->course_code,
            'course_professor' => $this->course->professor->name,
            'cover_image' => url('images/courses/covers/'.$this->course->cover_image),
            'progress' => $this->progress,
        ];
    }
}
