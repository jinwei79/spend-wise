<?php

use App\Http\Controllers\Auth\SocialiteController;
use App\Livewire\Expense\Create;
use App\Livewire\Expense\Edit;
use App\Livewire\Expense\Index;
use App\Livewire\Expense\Show;
use App\Livewire\Expense\ShowByDate;
use App\Livewire\Expense\Category\Edit as CategoryEdit;
use App\Livewire\Expense\Category\Index as CategoryIndex;
use App\Livewire\Expense\Category\View as CategoryView;
use App\Livewire\Budget\Index as BudgetIndex;
use App\Livewire\Budget\Edit as BudgetEdit;
use App\Livewire\Budget\View as BudgetView;
use App\Livewire\Chatbot;
use App\Livewire\Report\ExpenseReport;
use App\Services\GroqService;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('login');
});


Route::get('/auth/google/redirect', [SocialiteController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [SocialiteController::class, 'handleGoogleCallback']);


Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');


Route::get('/mainpage', function () {
    return view('mainpage');
})->name('mainpage');
Route::get('/contactus', function () {
    return view('contactus');
})->name('contactus');




Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('mainpage'); // or home page
    }
    return view('index'); // Blade or even static if embedded
});
Route::get('/force-login', function () {
    $user = User::find(3); // or use skip(2)->first()
    Auth::login($user);

    if (Auth::check()) {
        return 'Logged in as: ' . Auth::user()->name;
    }

    return 'Login failed';
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('mainpage');
    })->name('dashboard');

    Route::get('/chatbot', Chatbot::class)->name('chatbot');

    Route::get('/profile', function () {
        $user = Auth::user(); // Get currently logged-in user
        return view('profile.profile_form', compact('user')); // Pass it to the view
    })->name('profile.profile_form');

    Route::put('/profile', function (Request $request) {
        $user = Auth::user();  // Get the currently logged-in user

        // Validate input including file
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'birthday' => 'required|date',
            'salary' => 'nullable|numeric',
            'photo' => 'nullable|image|max:2048', // Optional photo
        ]);

        // Auto-generate full name
        $validatedData['name'] = $validatedData['first_name'] . ' ' . $validatedData['last_name'];

        // Handle photo upload if exists
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('profile-photos', 'public');
            $validatedData['profile_photo_path'] = $path;
        }

        // Update the user profile
        $user->update($validatedData);

        // Optionally add a success message or redirect
        return redirect()->route('profile.profile_form')->with('message', 'Profile updated successfully!');
    })->name('profile.update');



    Route::prefix('expense')->group(function () {
        Route::get('', Index::class)->name('expense.index');
        Route::get('create', Create::class)->name('expense.create');
        Route::get('show/{id}', Show::class)->name('expense.show');
        Route::get('show-by-date/{date}', ShowByDate::class)->name('expense.show-by-date');

    });

    Route::prefix('recurring-expense')->group(function () {
        Route::get('', App\Livewire\Expense\Recurring\Index::class)->name('recurring-expense.index');
        Route::get('create', App\Livewire\Expense\Recurring\Create::class)->name('recurring-expense.create');
        Route::get('show/{id}', App\Livewire\Expense\Recurring\Show::class)->name('recurring-expense.show');

    });

    Route::prefix('category')->group(function () {
        Route::get('', CategoryIndex::class)->name('category.index');
        Route::get('create', CategoryEdit::class)->name('category.create');
        Route::get('edit/{id}', CategoryEdit::class)->name('category.edit');
        Route::get('view/{id}', CategoryView::class)->name('category.view');
    });

    Route::prefix('budget')->group(function () {
        Route::get('', BudgetIndex::class)->name('budget.index');
        Route::get('create', BudgetEdit::class)->name('budget.create');
        Route::get('edit/{id}', BudgetEdit::class)->name('budget.edit');
        Route::get('view/{id}', BudgetView::class)->name('budget.view');
    });

    Route::get('edit/{id}', Edit::class)->name('expense.edit');
    Route::get('/report/expense', ExpenseReport::class)->name('report.expense');
});

Route::get('/test-groq', function () {
    $groqService = new GroqService();
    $response = $groqService->getExpenseCategory();
    return response()->json($response);
})->name('test-groq');

