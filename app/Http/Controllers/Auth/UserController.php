<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
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

    /**
     * @param \Illuminate\Http\Request $request
     * @param $ids \Illuminate\Database\Eloquent\Collection
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $ids = $request->user()->contacts()->pluck('id');
        $ids->push($request->user()->id);
        $query  = $request->get('query');
        $result = User::query()
            ->whereNotIn('id', $ids->toArray())
            ->where('name', 'like', $query . '%')
            ->get();

        return response()->json($result);
    }
}
