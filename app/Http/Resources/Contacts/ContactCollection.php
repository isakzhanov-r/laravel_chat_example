<?php

namespace App\Http\Resources\Contacts;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \App\Models\User */
class ContactCollection extends ResourceCollection
{
    /**
     * @var \Illuminate\Support\Collection
     */
    protected $requested;

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->getCollection(),
        ];
    }

    public function with($request)
    {
        return $this->requested
            ? ['requested' => $this->requested]
            : [];
    }

    protected function getCollection()
    {
        $this->requested = collect();

        return $this->collection->transform(function ($user) {
            if ($user->pivot->confirmed) {
                return UserResource::make($user);
            }
            $this->requested->push(UserResource::make($user));
        })->filter()
            ->values();
    }
}
