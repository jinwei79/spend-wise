<?php
namespace App\Livewire\Profile;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class Profile extends Component
{
    use WithFileUploads;

    public $photo;
    public $salary;
    public $first_name;
    public $last_name;
    public $email;
    public $username;
    public $birthday;
    public $message;

    public function mount()
    {
        $user = Auth::user();
        logger('Authenticated User: ' . $user->name); // Add a log for debugging
        $this->salary = $user->salary;
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->username = $user->username;
        $this->birthday = $user->birthday;
    }

    public function getProfilePhotoUrlProperty()
    {
        $user = Auth::user();
        return $user->profile_photo_path
            ? secure_asset('storage/' . $user->profile_photo_path)
            : $user->profile_photo_url;
    }

    public function getNameProperty()
    {
        return Auth::user()->name;
    }

    public function save(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => ['required','email', Rule::unique('users')->ignore($user->id)],
            'username'   => 'required|string|max:255',
            'birthday'   => 'required|date',
            'salary'     => 'nullable|numeric',
            'photo'      => 'nullable|image|max:2048',
        ]);

        // Add full name to the validated data
        $validated['name'] = $validated['first_name'] . ' ' . $validated['last_name'];

        // update basic fields
        $user->update($validated);

        // handle photo
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('profile-photos', 'public');
            $user->update(['profile_photo_path' => $path]);
        }

        return redirect()
            ->route('profile.profile_form')
            ->with('message', 'Profile updated successfully');
    }

    public function render()
    {
        return view('profile.profile_form')
            ->layout('layouts.app');
    }
}

