<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    // Display a listing of the books
    public function index()
    {
        $books = Book::with('category', 'publisher')
            ->orderBy('title')
            ->get();

        return view('pages.books.index', compact('books'));
    }

    // Show the form for creating a new book
    public function create()
    {
        $categories = Category::all();
        $publishers = Publisher::all();

        return view('pages.books.create', compact('categories', 'publishers'));
    }

    public function store(StoreBookRequest $request)
    {
        // Validated data will be automatically available here
        $validatedData = $request->validated();

        // Handle file upload
        if ($request->hasFile('cover_image')) {
            // Store the file and get the path
            $path = $request->file('cover_image')->store('covers', 'public');

            // Save the path to the validated data
            $validatedData['cover_image'] = $path;
        }

        // Create a new book with validated data
        Book::create($validatedData);

        return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    // Show book detail by ID
    public function show(Book $book)
    {
        return view('pages.books.show', compact('book'));
    }

    // Show the form for editing the specified book
    public function edit(Book $book)
    {
        $categories = Category::all();
        $publishers = Publisher::all();

        return view('pages.books.edit', compact('book', 'categories', 'publishers'));
    }

    // Update the specified book in the database
    public function update(UpdateBookRequest $request, $id)
    {
        $book = Book::findOrFail($id);
        $validatedData = $request->validated();

        // Handle file upload
        if ($request->hasFile('cover_image')) {
            // Delete the old cover image if it exists
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }

            // Store the new file and get the path
            $path = $request->file('cover_image')->store('covers', 'public');

            // Save the path to the validated data
            $validatedData['cover_image'] = $path;
        } else {
            // If no new file is uploaded, keep the old cover image
            unset($validatedData['cover_image']);
        }

        $book->update($validatedData);

        return redirect()->route('books.index')->with('success', 'Buku berhasil diperbarui.');
    }

    // Remove the specified book from the database
    public function destroy(Book $book)
    {
        // Check if the book has a cover image
        if ($book->cover_image) {
            // Delete the cover image from storage
            Storage::disk('public')->delete($book->cover_image);
        }

        // Soft delete the book from the database
        $book->delete();

        return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus.');
    }

    // Method to display trashed books (soft deleted books)
    public function trashed()
    {
        // Retrieve only soft deleted books
        $books = Book::onlyTrashed()->get();

        // The view may not exist.
        // Define the view first to display the list of deleted books.
        return view('pages.books.trashed', compact('books'));
    }

    // Method to restore a soft deleted book
    public function restore($id)
    {
        // Retrieve the soft deleted book by its ID
        $book = Book::withTrashed()->findOrFail($id);
        $book->restore(); // Restore the soft deleted book

        return redirect()->route('books.index')->with('success', 'Buku berhasil dipulihkan.');
    }

    // Method to permanently delete a soft deleted book
    public function forceDelete($id)
    {
        // Retrieve the soft deleted book by its ID
        $book = Book::withTrashed()->findOrFail($id);

        // Delete the cover image if it exists
        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }

        // Permanently delete the book from the database
        $book->forceDelete();

        return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus secara permanen.');
    }
}
