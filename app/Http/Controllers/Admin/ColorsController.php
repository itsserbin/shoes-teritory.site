<?php

namespace App\Http\Controllers\Admin;

use App\Models\Colors;
use Illuminate\Http\Request;

class ColorsController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

   public function index()
   {
       $colors = Colors::all();
       return view('admin.options.colors.index', [
           'colors' => $colors
       ]);
   }

   public function store(Request $request)
   {
        $colors = new Colors();
        $data = $request->all();
        $colors->create($data);

        return back();
   }

   public function destroy($id)
   {
       Colors::destroy($id);

       return back();
   }
}
