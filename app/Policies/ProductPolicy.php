<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    // Allow admin or owner of the product (Merchant Client) to update the product
    public function update(User $user, Product $product)
    {
        return $user->hasRole('Admin') || $user->id === $product->user_id;
    }

    // Allow admin or owner of the product (Merchant Client) to delete the product
    public function delete(User $user, Product $product)
    {
        return $user->hasRole('Admin') || $user->id === $product->user_id;
    }
}
