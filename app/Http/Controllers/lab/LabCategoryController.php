<?php

namespace App\Http\Controllers\lab;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\lab\labCategory;

class LabCategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Fetch all medika obat records with search and pagination
        $sub_category = labCategory::when($search, function ($query) use ($search) {
            return $query->where('category_lab', 'like', '%' . $search . '%');
        })->paginate(10); // Adjust the number of items per page as needed

        return view('admin.Laboratorium.SubCategory.index', compact('sub_category', 'search')); // Pass the search term to the view
    }
    public function create()
    {
        return view('admin.Laboratorium.SubCategory.create'); // Adjust the view path as necessary
    }
    public function store(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'category_lab' => 'required|string|max:255',
        ]);
    
        // Create a new medika obat record using validated data
        labCategory::create($validatedData);
    
        return redirect()->route('category_lab.index')->with('success', 'Sub Category Lab created successfully.');
    }
    public function show($id)
    {
        $sub_category = labCategory::findOrFail($id);
        return view('admin.Laboratorium.SubCategory.show', compact('sub_category')); // Adjust the view path as necessary
    }
    public function edit($id)
    {
        $sub_category = labCategory::findOrFail($id);
        return view('admin.Laboratorium.SubCategory.edit', compact('sub_category')); // Adjust the view path as necessary
    }
    public function update(Request $request, $id)
    {
    // Validate the request
    $validatedData = $request->validate([
        'category_lab' => 'required|string|max:255',
    ]);


    // Find the medika obat record and update it
    $sub_category = labCategory::findOrFail($id);
    $sub_category->update($validatedData);

    return redirect()->route('category_lab.index')->with('success', 'Sub Category Lab updated successfully.');
    }
    public function destroy($id)
    {
        // Find the medika obat record and delete it
        $sub_category = labCategory::findOrFail($id);
        $sub_category->delete();

        return redirect()->route('category_lab.index')->with('success', 'Sub Category Lab deleted successfully.');
    }
}
