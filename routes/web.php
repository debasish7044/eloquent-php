<?php

use App\Models\Comment;
use App\Models\Country;
use App\Models\Photo;
use App\Models\Post;
use App\Models\Role;
use App\Models\User;
use App\Models\Video;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// find a user
Route::get('/users/{id}', function ($id) {

    $user = User::findOrFail($id);
    echo 'Name: - ' .$user->name . "<br>";
    echo 'email: - ' .$user->email;
});

// find a blog belong to a user
// one to one relation ship

Route::get('/users/{id}/post', function ($id) {

    $user = User::findOrFail($id);
    echo $user->name . " Post : " . $user->post->title;
});


// find user belong to a post
// one to one relation ship
Route::get('/posts/{id}/user', function ($id) {

    $post = Post::findOrFail($id);
    echo $post->title . " Post belongs to " . $post->user->name;
});


// find all posts belongs to a one user
// one to many relation ship
Route::get('/users/{id}/posts', function ($id) {

     $user = User::findOrFail($id);
     echo $user->name .' all post name : <br>';
     foreach($user->posts as $post){
         echo $post->title . "<br>";
     }
});


// find user roles
// one to many relation ship
Route::get('/users/{id}/role', function ($id) {

  $user = User::find($id);
  $roles = $user->roles()->orderBy('name')->get();
  echo $user->name . ' roles are :' . "<br>";
  foreach($roles as $role){
      echo $role->name . ' ';
  }

});

// find all users with a same roles
// one to many relation ship
Route::get('/roles/{id}/users', function ($id) {

  $role = Role::find($id);

  $users = $role->users;

  echo $role->name .' has ' . count($users) . ' users <br>';
  foreach($users as $user){
     echo   $user->name . ' ';
  }

});

  // Has one through relation ship
   Route::get('/user/{id}/country',function($id){

       $country = Country::find($id)->post;
         echo $country->title;

   });

// Has many through relation ship
   Route::get('/users/{id}/country',function($id){

       $country = Country::find($id)->posts;

        foreach($country as $post){
            echo $post->title . ' ';
        }
   });


//   Polymorphic one to one relationship
// Retrieving image from a post
Route::get('/post/{id}/image',function($id){
    $post = Post::find($id);

    return $post->image;
    // $image = $post->image;
    // return $image;
});


//   Polymorphic one to one relationship
// Retrieving image from a user
Route::get('/user/{id}/post/image',function($id){
    $user = User::find($id);

    return $user->image;
    // $image = $post->image;
    // return $image;
});


// polymorphic relationship
// find the image owner
Route::get('/user/{id}/post/owner',function($id){
   $photo =  Photo::findOrFail($id);
   return $photo->imageable;
});


// polymorphic relationship one to many
// find the post comments
Route::get('/post/{id}/comments',function($id){
   $post = Post::find($id);

    foreach ($post->comments as $comment) {
        echo $comment->body;
    }
});


// polymorphic relationship one to many
// find the video comments
Route::get('/video/{id}/comments',function($id){
   $video = Video::find($id);

    foreach ($video->comments as $comment) {
        echo $comment->body;
    }
});


// polymorphic relationship one to many
// find the video comment owner
Route::get('/video/{id}/comments/owner',function($id) {
   $comment = Comment::find($id);

   echo $comment->commentable;

});


// polymorphic relationship Many to many
// find the video comment owner
Route::get('/post/{id}/tag',function($id) {
   $post = Post::find($id);

    foreach ($post->tags as $tag) {
        echo $tag->name;
    }
});

// polymorphic relationship Many to many
// find the video comment owner
Route::get('/video/{id}/tag',function($id) {
   $video = Video::find($id);

    foreach ($video->tags as $tag) {
        echo $tag->name;
    }
});



