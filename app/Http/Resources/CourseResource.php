<?php

namespace App\Http\Resources;

use App\Models\Course;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
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
            'course_name' => $this->course->course_name,
            'course_code' => $this->course->course_code,
            'progress' => min(intval($this->progress) / count($this->course->lectures) * 100, 100),
            'lectures' => LecturesResource::collection($this->course->lectures)
        ];
    }
}
