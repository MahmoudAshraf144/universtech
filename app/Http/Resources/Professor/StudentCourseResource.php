<?php

namespace App\Http\Resources\Professor;

use App\Models\Attendance;
use App\Models\Course;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentCourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'attendances' => Attendance::where('course_id', $this->pivot->course_id)->where('student_id', $this->pivot->student_id)->get(),
            'created_at' => $this->created_at
        ];
    }
}
