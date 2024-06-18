<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [];
        $data['id'] = $this->id;
        $data['title'] = $this->title;
        $data['content'] = "Dear ".auth()->user()->name."\n".$this->content;
        $data['type'] = $this->type ? 'event' : 'notification';

        if($this->type == 0)
        {
            $data['professor'] =  $this->professor->name;
        }
        else
        {
            $data['admin'] =  $this->admin->name;
            $data['image_path'] = url($this->image_path);
        }

        $data['created_at'] = $this->created_at->diffForHumans();

        return $data;
    }
}
