<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $user = Auth::user();
        // return view('user.index', compact('user'));
        if (Auth::check()) {
            $user = Auth::user();
            return view('user.index', compact('user'));
        } else {
            return redirect()->route('login'); // ログインページにリダイレクト
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // ユーザー情報の取得
        $user = User::findOrFail($id);
        // ユーザー情報の詳細ページを表示
        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // ユーザー情報の取得
        $user = User::findOrFail($id);
        // ユーザー情報の編集ページを表示
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        // $this->authorize('update', $user);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            // 'icon'=>'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // 画像バリデーション
            'icon' => 'nullable|image|max:2048', // image は JPEG, PNG, BMP, GIF, SVG を許可
        ]);

         // アイコンのアップロード処理
        if ($request->hasFile('icon')) {
            $path = $request->file('icon')->store('public/images'); // アイコンを storage に保存
            $user->icon = $path; // 保存したパスをデータベースに保存
        }
    
        // ユーザー情報の更新
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);

        // 更新が成功した場合はリダイレクト
        return redirect()->route('user.index')->with('flash_message', 'ユーザー情報が更新されました。');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('user.index')->with('flash_message', 'ユーザー情報が削除されました。');
        
    }
}
