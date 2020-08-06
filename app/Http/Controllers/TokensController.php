<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreToken;

use App\User;
use App\PersonalAccessToken;

use App\Events\ModelChanged;

class TokensController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Tokens Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the issue an maintenance of personal access tokens
    | that are used to secure access to the API.
    |
    */

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        return view('tokens.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = $request->user();
        return view('tokens.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreToken $request)
    {
        $token_name = $request->name;
        $user = $request->user();
        $token = $user->createToken($token_name);
        // audit
        $before = [];
        $after = $token->accessToken->attributesToArray();
        event(new ModelChanged(
            $user->id,
            User::class,
            PersonalAccessToken::class,
            $before,
            $after,
            'created'
        ));
        return view('tokens.view', compact('token'));
    }

    /**
    * Confirm the deletion of the personal access token.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function delete(Request $request, $id)
    {
        $user = $request->user();
        $token = $user->tokens()->findOrFail($id);

        // confirm delete
        return view('tokens.revoke', compact('token'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        $token = PersonalAccessToken::findOrFail($id);
        $before = [];
        $after = $token->attributesToArray();
        $token = $user->tokens()->where('id', $id)->delete();
        // audit
        event(new ModelChanged(
            $user->id,
            User::class,
            PersonalAccessToken::class,
            $before,
            $after,
            'deleted'
        ));
        return redirect('/tokens');
    }
}
