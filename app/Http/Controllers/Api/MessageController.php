<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Messages\StoreRequest;
use App\Http\Resources\Messages\MessageResource;
use App\Models\User;
use App\Services\Eloquent\MessageService;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    protected $service;

    public function __construct(MessageService $service)
    {
        $this->middleware('auth');
        $this->service = $service;
    }

    public function index($to)
    {
        $data = $this->service
            ->setContact($to)
            ->getMessages();

        return MessageResource::collection($data);
    }

    public function store(StoreRequest $request, $to)
    {
        $data = $this->service
            ->setContact($to)
            ->send($request);

        return MessageResource::make($data);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, $id)
    {
        //
    }
}
