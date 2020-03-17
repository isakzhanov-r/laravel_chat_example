<?php

namespace App\Http\Resources\Messages;

use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Message */
class MessageResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'from'       => $this->from,
            'to'         => $this->to,
            'message'    => $this->message,
            'is_read'    => $this->is_read,
            'created_at' => $this->created_at,
        ];
    }
}
