<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class AdminClientController extends Controller
{
   public function index(Request $request)
    {
        $query = Client::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            });
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        if ($request->filled('area')) {
            $query->where('area', 'like', "%{$request->area}%");
        }

        $clients = $query->latest()->paginate(10);

        return view('admin.clients.index', compact('clients'));
    }

    public function show(Client $client)
    {
        $client->load('orders'); // Eager-load orders
        return view('admin.clients.show', compact('client'));
    }
}
