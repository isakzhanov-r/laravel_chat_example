<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function info()
    {
        $user = \Auth::user();

        return new JsonResource($user);
    }

    public function update(Request $request)
    {
        $data = ['name' => $request->get('name')];
        if ($request->get('change_password')) {
            Arr::set($data, 'password', Hash::make($request->get('password')));
        }
        $request->user()->update($data);

        return new JsonResource($request->user());
    }
}
