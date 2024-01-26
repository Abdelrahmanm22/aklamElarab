<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    //
    public function index()
    {

        $chartjs = $this->topAuthors();
        return view('index', compact('chartjs'))->with('title', 'Home');
    }

    public function topAuthors()
    {
        // Get top 5 authors based on views
        $topAuthors = User::select('users.*', DB::raw('SUM(books.view) as total_views'))
            ->join('books', 'users.id', '=', 'books.author_id')
            ->groupBy('users.id')
            ->orderByDesc('total_views')
            ->limit(5)
            ->get();

        // return $topAuthors;
        $views = [];
        $names = [];
        // Loop through the topAuthors and add names and views to the arrays
        for ($i = 0; $i < min(5, count($topAuthors)); $i++) {
            array_push($names, $topAuthors[$i]->name);
            array_push($views, $topAuthors[$i]->total_views);
        }
        // return $views;

        $chartjs = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 350, 'height' => 200])
            ->labels($names)
            ->datasets([
                [
                    'backgroundColor' => ['#0a2459
        ', '#59520a', '#3b0606', '#063b1f', '#063a3b'],
                    'data' => $views
                ]


            ])
            ->options([]);

        return $chartjs;
    }
}
