<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserContact
 *
 * @property int $user_id
 * @property int $contact_id
 * @property bool $confirmed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserContact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserContact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserContact query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserContact whereConfirmed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserContact whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserContact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserContact whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserContact whereUserId($value)
 * @mixin \Eloquent
 */
class UserContact extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'contact_id', 'confirmed',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'confirmed' => 'boolean',
    ];
}
