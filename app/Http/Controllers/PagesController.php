<?php

namespace App\Http\Controllers;

use App\Post;

class PagesController extends Controller {
    
    public function getIndex(){
        $posts = Post::orderBy('created_at', 'desc')->limit(4)->get();
        return view('pages.welcome')->withPosts($posts);
    }

    public function getAbout(){
       /* $first= 'Alex';
        $last = 'Curtis';
        $full = $first." ".$last;

        return view ('pages.about')->with("fullname",$full);*/ //drugi nacin za prikazivanje funkcija in view

        $first= 'Alex';
        $last = 'Curtis';
        $full = $first." ".$last;
        $email = "alexC@mail.com";

        return view ('pages.about')->withFullname($full)->withEmail($email);
    }

    public function getContact(){
        return view('pages.contact');
    }
}