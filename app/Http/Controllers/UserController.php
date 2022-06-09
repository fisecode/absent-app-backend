<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // if ($request->ajax()) {
        //     $data = User::query();

        //     return DataTables::eloquent($data)
        //         ->addColumn('action', function ($data) {
        //             return view('layouts._action', [
        //                 'model' => $data,
        //                 'edit_url' => route('user.edit', $data->id),
        //                 'show_url' => route('user.show', $data->id),
        //                 'delete_url' => route('user.destroy', $data->id),
        //             ]);
        //         })
        //         ->addIndexColumn()
        //         ->rawColumns(['action'])
        //         ->toJson();
        // }
        $users = User::all();

        return view('user.index')->with('users', $users);
    }
}
