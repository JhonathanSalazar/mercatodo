<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function home() {
        return view('home');
    }

    public function userAccount() {
        return view('pages.userAccount');
    }

    public function yourCar() {
        return view('pages.yourCar');
    }

    public function checkout() {
        return view('pages.checkout');
    }

    public function aboutUs() {
        return view('pages.about');
    }

    public function contactUs() {
        return view('pages.contact');
    }
}
