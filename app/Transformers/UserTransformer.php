<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'user_name' => $user->user_name,
            'name' => $user->name,
            'email' => $user->email,
//            'password' => $user->password,
            'phone_number' => $user->phone_number,
            'department' => $user->department,
            'profile_url' => $user->profile_url,
            'is_admin' => $user->is_admin
        ];
    }
}
