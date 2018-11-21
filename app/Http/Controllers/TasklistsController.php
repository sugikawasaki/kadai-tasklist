<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Tasklist;

class TasklistsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        if (\Auth::check()) {
            $user = \Auth::user();
            $tasklists = $user->tasklists()->orderBy('created_at','desc')->paginate(10);
            
            $data = [
                'user' => $user,
                'tasklists' => $tasklists,
            ];
            $data += $this->counts($user);
            return view('tasklists.index', $data);
        }else {
            return view('welcome');
        }


        $tasklists = Tasklist::all();
        
        return view('tasklists.index',[
            'tasklists' => $tasklists,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tasklist = new Tasklist;
        
        return view('tasklists.create',[
            'tasklist' => $tasklist,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'status' => 'required|max:10',
            'content' => 'required|max:10',
            ]);
        
        $request->user()->tasklists()->create([
            'status' => $request->status,
            'content' => $request->content,
            ]);
            
        return redirect('/tasklists');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //表示すべきタスクを取得する
        $tasklist = Tasklist::find($id);
        
        //そのタスクの持ち主とログインしているユーザ－が一致しているか調べる
        if(\Auth::id()=== $task->user_id){
        //一致していたら詳細ページを表示
        return view('tasklists.show',[
            'tasklist' => $tasklist,
        ]);            
            
            //いまcontrollerに書かれている処理
        }else{
            //一致していなかったらTOPに飛ばす
            return redirect('/');
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //編集すべきタスクを取得する
        $tasklist = Tasklist::edit($id);
        
        //そのタスクを持ち主とログインしているユーザーが一致しているかを調べる
        if(\Auth::id()===$task->user_id){
        //一致していたら編集ページを表示
        return view('tasklists.edit',[
            'tasklist' => $tasklist,
        ]);
        //いまcontrollerに書かれている処理
        }else{
            //一致していなかったらTOPに飛ばす
            return redirect('/');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|max:10',
            'content' => 'required|max:10',
            ]);
            
        $tasklist = Tasklist::find($id);
        $tasklist->status = $request->status;
        $tasklist->content = $request->content;
        $tasklist->save();
        
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tasklist = \App\Tasklist::find($id);
        
        if(\Auth::id() === $tasklist->user_id) {
            $tasklist->delete();
        }
        
        return redirect()->back();
    }
}
