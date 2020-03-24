<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Messages\StoreRequest;
use App\Http\Resources\Messages\MessageResource;
use App\Models\Message;
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
            ->getMessages()
            ->sortBy('created_at');

        return MessageResource::collection($data)->additional(['count' => $data->count()]);
    }

    public function notReadMessages()
    {
        $data = $this->service
            ->getUnreadMessages();

        return MessageResource::collection($data);
    }

    public function store(StoreRequest $request, $to)
    {
        $data = $this->service
            ->setContact($to)
            ->send($request);

        return MessageResource::make($data);
    }

}
