<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ItemController extends Controller
{
    public function show(string $id): View
    {
        return view('items.show', compact('id'));
    }
}