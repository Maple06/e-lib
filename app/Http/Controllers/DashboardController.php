<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.index');
    }

    public function export($month)
    {
        echo '<script>alert("Not Implemented")</script>';
    }

    public function getBooksByMonthData(Request $request)
    {
        // Get all borrowings for the year 2024 and process them in PHP
        $borrowings = Borrowing::whereYear('borrow_date', 2024)->get()->groupBy(function ($date) {
            return Carbon::parse($date->borrow_date)->format('m'); // Group by months
        });

        $borrowingsCount = [];
        $borrowMonths = [];
        foreach ($borrowings as $key => $value) {
            $borrowingsCount[(int) $key] = count($value); // Count the number of borrowings for each month
            $borrowMonths[(int) $key] = Carbon::create()->month($key)->locale('id')->isoFormat('MMM'); // Get the month name in Indonesian
        }

        ksort($borrowingsCount);
        ksort($borrowMonths);

        return response()->json([
            'borrowings' => array_values($borrowingsCount),
            'months' => array_values($borrowMonths),
        ]);
    }

    public function getBookCategories(Request $request)
    {
        try {
            // Fetch all books and group by category
            $books = Book::with('category')->get();  // Eager load the category relation
            $totalBooks = $books->count();

            // Group books by category and calculate percentage
            $percentages = $books->groupBy('category.name')
                ->map(function ($categoryBooks, $categoryName) {
                    return [
                        'name' => $categoryName,
                        'y' => $categoryBooks->count(),
                    ];
                })->values(); // Use values() to reset the keys of the collection

            // Return the response
            return response()->json($percentages);
        } catch (\Exception $e) {
            // Log the exception message
            \Log::error($e->getMessage());

            // Return a user-friendly error message
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    public function getPopularCategories(Request $request)
    {
        try {
            // Fetch all books and group by category
            $books = Book::with('category')->get();
            $totalBooks = $books->count();

            // Group books by category, calculate count and sort by count descending
            $groupedBooks = $books->groupBy('category.name')
            ->map(function ($categoryBooks, $categoryName) {
                return [
                    'name' => $categoryName,
                    'y' => $categoryBooks->count(),
                ];
            })
                ->sortByDesc('y') // Sort by the count descending
                ->take(3) // Get the top 3 categories
                ->values(); // Reset the keys of the collection

            // Prepare the response in the desired format
            $categories = $groupedBooks->pluck('name')->map(function ($name, $index) {
                return '#'.($index + 1).' &emsp; '.$name;
            });

            $colors = ['#F1C40F', '#3357FF', '#E84A3F']; // Define your colors here

            $data = $groupedBooks->map(function ($item, $index) use ($colors) {
                return [
                    'y' => $item['y'],
                    'color' => $colors[$index] ?? '#C1E41F', // Default color if more than 3 categories
                ];
            });

            \Log::debug(response()->json([
                'categories' => $categories,
                'data' => $data,
            ]));

            // Return the response
            return response()->json([
                'categories' => $categories,
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            // Log the exception message
            \Log::error($e->getMessage());

            // Return a user-friendly error message
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    public function getBookStatuses(Request $request)
    {
        try {
            \Log::info('We are in getBookStatuses');
            $latestStatusSubquery = DB::table('borrowings')
                ->select('book_id', DB::raw('MAX(created_at) as latest_date'))
                ->groupBy('book_id');

            // Get not returned yet books with late_fee > 0
            $notReturnedLateFeeCount = Borrowing::joinSub($latestStatusSubquery, 'latest_status', function ($join) {
                $join->on('borrowings.book_id', '=', 'latest_status.book_id')
                    ->on('borrowings.created_at', '=', 'latest_status.latest_date');
            })
            ->where('borrowings.status', 'dipinjam')
            ->where('borrowings.late_fee', '>', 0)
            ->distinct('borrowings.book_id')
            ->count('borrowings.book_id');

            // Get currently being borrowed books with late_fee = 0
            $currentlyBorrowedNotLateCount = Borrowing::joinSub($latestStatusSubquery, 'latest_status', function ($join) {
                $join->on('borrowings.book_id', '=', 'latest_status.book_id')
                    ->on('borrowings.created_at', '=', 'latest_status.latest_date');
            })
            ->where('borrowings.status', 'dipinjam')
            ->where('borrowings.late_fee', 0)
            ->distinct('borrowings.book_id')
            ->count('borrowings.book_id');

            \Log::info('Not Returned Late Fee Count: '.$notReturnedLateFeeCount);
            \Log::info('Currently Borrowed Not Late Count: '.$currentlyBorrowedNotLateCount);

            return [
                'categories' => ['Tersedia', 'Disewa', 'Belum Kembali'],
                'data' => [
                    [
                        'y' => 50,
                        'color' => '#00a0b4',
                    ],
                    [
                        'y' => 24,
                        'color' => '#f39c12',
                    ],
                    [
                        'y' => 3,
                        'color' => '#dd4b39',
                    ],
                ],
            ];

            // // Group books by category and calculate percentage
            // $percentages = $books->groupBy('category.name')
            //     ->map(function ($categoryBooks, $categoryName) use ($totalBooks) {
            //         return [
            //             'name' => $categoryName,
            //             'y' => ($categoryBooks->count() / $totalBooks) * 100,
            //         ];
            //     })->values(); // Use values() to reset the keys of the collection

            // // dd($percentages);

            // // Return the response
            // return response()->json($percentages);
        } catch (\Exception $e) {
            // Log the exception message
            \Log::error($e->getMessage());

            // Return a user-friendly error message
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }
}
