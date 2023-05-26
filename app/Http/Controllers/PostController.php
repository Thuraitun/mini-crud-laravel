<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{

    //To Go Create Page

    public function create() {

        // $posts = Post::orderBy('created_at', 'desc')->paginate(3)->through(function($post){
        //     $post->title = strtoupper($post->title);
        //     return $post;
        // });

        $posts = Post::when(request('searchKey'), function($query) {
                $key = request('searchKey');
                $query->orwhere('title', 'like', "%$key%")
                      ->orwhere('description', 'like', "%$key%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(3)
            ->through(function($post){
                    $post->title = strtoupper($post->title);
                    return $post;
                });


        return view('create', compact('posts'));
    }


    // Post Create

    public function postCreate(Request $request) {

        // Use Private Function for validation

        $this->validationCheck($request);
        $data = $this->getPostData($request);


        if($request->hasFile('postImage')) {

            $fileName = uniqid() . $request->file('postImage')->getClientOriginalName();
            $request->file('postImage')->storeAs('public', $fileName);
            $data['image'] = $fileName;
        }


        Post::create($data); //Send data to Database with Post Model

        // return back();
        return redirect()->route('post#createPage')->with(['createdSuccess'=>'Post Created !!']);
    }

    public function postDelete($id) {

        //first way

        Post::where('id', $id)->delete();

        // second way

        // Post::find($id)->delete();

        return back();
    }

    public function postUpdate($id) {
        $post = Post::where('id', $id)->first(); //you can use get(). get() is array[0]
        // dd($post);

        // $post = Post::find($id);
        // dd($post);

        return view('update',compact('post'));

        // return view('update', [ 'post' -> $post]);
    }

    public function postEdit($id){
        $post = Post::where('id', $id)->first()->toArray();
        // dd($post);


        return view('edit', compact('post'));
    }

    public function update(Request $request){

        $this->validationCheck($request);
        $data = $this->getPostData($request);
        $id = $request->postId;

        if($request->hasFile('postImage')) {

            // Delete Old Image

            $oldImageName = Post::select('image')->where('id', $request->postId)->first()->toArray();
            $oldImageName = $oldImageName['image'];

            if($oldImageName != null) {
                Storage::delete('public/'. $oldImageName);
            }

            $fileName = uniqid() . $request->file('postImage')->getClientOriginalName();
            $request->file('postImage')->storeAs('public', $fileName);
            $data['image'] = $fileName;
        }


        Post::where('id', $id)->update($data);
        // dd($data);

        return redirect()->route('post#createPage')->with(['updatedSuccess'=>'Updated Post !!!']);
    }



    // get post Data with Private function

    private function getPostData($request) {
        return [
            'title' => $request->postTitle,
            'description' => $request->postDescription,
            'price' => $request->postPrice,
            'address' => $request->postAddress,
            'rating' => $request->postRating,
        ];
    }

    // get post create validation function

    private function validationCheck($request){

        $validationRule = [
            'postTitle' => "required|min:5|unique:posts,title,$request->postId",
            'postDescription' => 'required|min:5',
            'postPrice' => 'required',
            'postAddress' => 'required',
            'postRating' => 'required',
            'postImage' => 'mimes:jpg,jpeg,png|file',
        ];

        // custom validation message

        $validationMessage = [
            'postTitle.required' => 'Post Title ဖြည့်ရန် လိုအပ်ပါသည်။',
            'postTitle.min' => 'စကားလုံးအနည်းဆုံး ၅လုံးအထက်ဖြစ်ရမည်။',
            'postTitle.unique' => 'အသုံးပြုပြီးဖြစ်ပါသဖြင့် အသစ်ထပ်မံဖြည့်သွင်းပေးပါ။',
            'postDescription.required' => 'Post Description ဖြည့်ရန် လိုအပ်ပါသည်။',
            'postDescription.min' => 'စကားလုံးအနည်းဆုံး ၅လုံးအထက်ဖြစ်ရမည်။',
            'postPrice.required' => 'Post Price ဖြည့်ရန် လိုအပ်ပါသည်။',
            'postAddress.required' => 'Post Address ဖြည့်ရန် လိုအပ်ပါသည်။',
            'postRating.required' => 'Post Rating ဖြည့်ရန် လိုအပ်ပါသည်။',
            'postImage.mimes' => 'Post Image jpg, jpeg, png ဖြစ်ရမည်။',

        ];

        Validator::make($request->all(), $validationRule, $validationMessage)->validate();
    }

}
