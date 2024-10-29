<?php

namespace App\Http\Controllers;

use App\Models\BanksMethod;
use Illuminate\Http\Request;

class BanksMethodController extends Controller
{
    public function index()
    {
        $banksMethod = BanksMethod::all();
        return view('gestion.bank', compact('banksMethod'));
    }

    public function store(Request $request)
    {
        $request->validate(BanksMethod::rules());

        BanksMethod::create($request->all());

        return redirect()->route('banks.index')->with('status', 'Bank method created successfully!');
    }

    public function edit(BanksMethod $banksMethod)
    {
        return response()->json($banksMethod);
    }

    public function update(Request $request, BanksMethod $banksMethod)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:banks_methods,name,' . $banksMethod->id,
        ]);

        $banksMethod->update($request->only('name'));

        return redirect()->route('banks.index')->with('status', 'Bank method updated successfully!');
    }

    public function destroy(BanksMethod $banksMethod)
    {
        $banksMethod->delete();
        return redirect()->route('banks.index')->with('status', 'Bank method deleted successfully!');
    }
}
