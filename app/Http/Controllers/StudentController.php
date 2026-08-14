<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(): string
    {
        return 'Student list from StudentController';
    }

    public function show(User $user): string
    {
        $name = $user->name ?? 'Unnamed';
        return "Student {$user->id} - {$name} from StudentController";
    }
}
