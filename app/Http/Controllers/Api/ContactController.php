<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contacts\StoreRequest;
use App\Http\Resources\Contacts\ContactCollection;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Services\Eloquent\ContactService;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    protected $services;

    public function __construct(ContactService $service)
    {
        $this->services = $service;
    }

    public function index()
    {
        $data = $this->services
            ->getAll($this->user());

        return new ContactCollection($data);
    }

    public function excepted()
    {
        $data = $this->user()
            ->load('excepted');

        return UserResource::collection($data->excepted);
    }

    public function store(StoreRequest $request)
    {
        $data = $this->services
            ->addContact($this->user(), $request);

        return UserResource::make($data);
    }

    public function confirm(StoreRequest $request)
    {
        $data = $this->services
            ->confirmContact($this->user(), $request);

        return UserResource::make($data);
    }

    public function show($id)
    {
        return UserResource::make(User::find($id));
    }

    protected function user(): User
    {
        return \Auth::user();
    }
}
