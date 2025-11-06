<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingArea;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminShippingAreaController extends Controller
{
    public function index()
    {
        $areas = ShippingArea::latest()->paginate(15);
        return view('admin.shipping_areas.index', compact('areas'));
    }

    public function create()
    {
        return view('admin.shipping_areas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_en' => 'required|string|max:255|unique:shipping_areas,name_en',
            'name_ar' => 'required|string|max:255|unique:shipping_areas,name_ar',
            'cost'    => 'required|numeric|min:0|max:99999.99',
            'is_active' => 'sometimes|boolean',
        ]);

        ShippingArea::create([
            'name_en'   => $request->name_en,
            'name_ar'   => $request->name_ar,
            'cost'      => $request->cost,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()
            ->route('admin.shipping-areas.index')
            ->with('status-success', 'Shipping area created successfully.');
    }

    public function edit(ShippingArea $shipping_area)
    {
        return view('admin.shipping_areas.edit', compact('shipping_area'));
    }

    public function update(Request $request, ShippingArea $shipping_area)
    {
        $request->validate([
            'name_en' => [
                'required',
                'string',
                'max:255',
                Rule::unique('shipping_areas')->ignore($shipping_area->id),
            ],
            'name_ar' => [
                'required',
                'string',
                'max:255',
                Rule::unique('shipping_areas')->ignore($shipping_area->id),
            ],
            'cost'    => 'required|numeric|min:0|max:99999.99',
            'is_active' => 'sometimes|boolean',
        ]);

        $shipping_area->update([
            'name_en'   => $request->name_en,
            'name_ar'   => $request->name_ar,
            'cost'      => $request->cost,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.shipping-areas.index')
            ->with('status-success', 'Shipping area updated successfully.');
    }

    public function destroy(ShippingArea $shipping_area)
    {
        if ($shipping_area->orders()->exists()) {
            return back()->with('status-error', 'Cannot delete: this area is used in existing orders.');
        }

        $shipping_area->delete();

        return redirect()
            ->route('admin.shipping-areas.index')
            ->with('status-success', 'Shipping area deleted successfully.');
    }
}
