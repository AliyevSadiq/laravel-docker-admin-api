<?php

namespace App\Http\Controllers;

use App\Http\Resources\PermissionResource;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
      $permissions=PermissionResource::collection(Permission::all());
      return response()->json($permissions);
    }
}
