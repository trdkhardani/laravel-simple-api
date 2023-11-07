<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthorizeCheckController extends Controller
{
    /**
     * check the user_id from the blogs table and compare it with the current logged in user (current token bearer).
     * If not same, return 403 (forbidden)
     */
    public function isNotAuthor($auth_user_id, $blog_user_id)
    {
        if ($auth_user_id !== $blog_user_id) {
            return abort(403, "You're not the author of this blog");
        }
    }
}
