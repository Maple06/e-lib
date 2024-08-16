<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Book;
use App\Models\Category;

class CategoryController extends Controller
{
    // Display a listing of the categories
    public function index()
    {
        $categories = Category::get();

        return view('pages.categories.index', compact('categories'));
    }

    // Show the form for creating a new category
    public function create()
    {
        return view('pages.categories.create');
    }

    // Show books with current category
    public function show(Category $category)
    {
        $books = Book::where('category_id', $category->id)
            ->orderBy('title')
            ->get();

        return view('pages.categories.show', compact('books'));
    }

    public function store(StoreCategoryRequest $request)
    {
        // Validated data will be automatically available here
        $validatedData = $request->validated();

        // Create a new category with validated data
        Category::create($validatedData);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    // Show the form for editing the specified category
    public function edit(Category $category)
    {
        return view('pages.categories.edit', compact('category'));
    }

    // Update the specified category in the database
    public function update(UpdateCategoryRequest $request, $id)
    {
        $category = Category::findOrFail($id);
        $validatedData = $request->validated();

        $category->update($validatedData);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    // Remove the specified category from the database
    public function destroy(Category $category)
    {
        // Soft delete the book from the database
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Kategori beserta dengan buku-bukunya berhasil dihapus.');
    }

    // Method to display trashed categories (soft deleted categories)
    public function trashed()
    {
        // Retrieve only soft deleted categories
        $categories = Category::onlyTrashed()->get();

        // The view may not exist.
        // Define the view first to display the list of deleted categories.
        return view('pages.categories.trashed', compact('categories'));
    }

    // Method to restore a soft deleted category
    public function restore($id)
    {
        // Retrieve the soft deleted category by its ID
        $category = Category::withTrashed()->findOrFail($id);
        $category->restore(); // Restore the soft deleted category

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dipulihkan.');
    }

    // Method to permanently delete a soft deleted category
    public function forceDelete($id)
    {
        // Retrieve the soft deleted category by its ID
        $category = Category::withTrashed()->findOrFail($id);

        // Permanently delete the category from the database
        $category->forceDelete();

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus secara permanen.');
    }
}
