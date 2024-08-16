<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePublisherRequest;
use App\Http\Requests\UpdatePublisherRequest;
use App\Models\Book;
use App\Models\Publisher;

class PublisherController extends Controller
{
    // Display a listing of the publishers
    public function index()
    {
        $publishers = Publisher::get();

        return view('pages.publishers.index', compact('publishers'));
    }

    // Show the form for creating a new publisher
    public function create()
    {
        return view('pages.publishers.create');
    }

    // Show books with current publisher
    public function show(Publisher $publisher)
    {
        $books = Book::where('publisher_id', $publisher->id)
            ->orderBy('title')
            ->get();

        return view('pages.publishers.show', compact('books'));
    }

    public function store(StorePublisherRequest $request)
    {
        // Validated data will be automatically available here
        $validatedData = $request->validated();

        // Create a new category with validated data
        Publisher::create($validatedData);

        return redirect()->route('publishers.index')->with('success', 'Penerbit berhasil ditambahkan.');
    }

    // Show the form for editing the specified publisher
    public function edit(Publisher $publisher)
    {
        return view('pages.publishers.edit', compact('publisher'));
    }

    // Update the specified publisher in the database
    public function update(UpdatePublisherRequest $request, $id)
    {
        $publisher = Publisher::findOrFail($id);
        $validatedData = $request->validated();

        $publisher->update($validatedData);

        return redirect()->route('publishers.index')->with('success', 'Penerbit berhasil diperbarui.');
    }

    // Remove the specified publisher from the database
    public function destroy(Publisher $publisher)
    {
        // Soft delete the publisher from the database
        $publisher->delete();

        return redirect()->route('publishers.index')->with('success', 'Penerbit berhasil dihapus.');
    }

    // Method to display trashed publisher (soft deleted publisher)
    public function trashed()
    {
        // Retrieve only soft deleted publisher
        $publisher = Publisher::onlyTrashed()->get();

        // The view may not exist.
        // Define the view first to display the list of deleted publisher.
        return view('pages.publishers.trashed', compact('publisher'));
    }

    // Method to restore a soft deleted publisher
    public function restore($id)
    {
        // Retrieve the soft deleted publisher by its ID
        $publisher = Publisher::withTrashed()->findOrFail($id);
        $publisher->restore(); // Restore the soft deleted publisher

        return redirect()->route('publishers.index')->with('success', 'Penerbit berhasil dipulihkan.');
    }

    // Method to permanently delete a soft deleted publisher
    public function forceDelete($id)
    {
        // Retrieve the soft deleted publisher by its ID
        $publisher = Publisher::withTrashed()->findOrFail($id);

        // Permanently delete the publisher from the database
        $publisher->forceDelete();

        return redirect()->route('publishers.index')->with('success', 'Penerbit berhasil dihapus secara permanen.');
    }
}
