<?php

use Illuminate\Http\Request;
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


Route::get('/datatable', function(){
    return view('datatable');
});

Route::get('/users', function(Request $request){
    $user = \App\User::query();
    
    $recordsTotal = $user->count();

    // search parameters
    
    $user->when($request->email, function($query) use($request){
        return $query->where('email','like','%'.$request->email.'%');
    });

    

    // $orderBy = $request->order[0]['column'];
    // $sortBy = $request->order[0]['dir'];

    // if($orderBy == 1){
    //     $orderBy = 'name';
    // }
    $recordsFiltered = $user->get()->count();
    $user->offset($request->start)->limit($request->length);

    $data = [
        'draw' => $request->draw,
        'recordsTotal' => $recordsTotal,
        'recordsFiltered' => $recordsFiltered,
        'data' => $user->get()
    ];
    return $data;
})->name('datatables');