<x-app-layout>
    <div class="flex items-center justify-center min-h-screen py-12">
    
        <div class="w-full max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
            <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Contact Us</h3>

            @if(session('success'))
                <div class="bg-green-500 text-white p-4 rounded-md mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form action="" method="POST" class="mt-4">
                @csrf
                <div class="mb-4">
                    <label for="full_name" class="block text-sm text-gray-600 dark:text-gray-400">Full Name</label>
                
                    <input type="text" name="full_name" id="full_name" class="mt-1 p-2 w-full border rounded-md" required value="{{ Auth::user()->name }}">
                </div>
                <div class="mb-4">
                    <label for="Email" class="block text-sm text-gray-600 dark:text-gray-400">Email</label>
                    <input type="text" name="Email" id="Email" class="mt-1 p-2 w-full border rounded-md" required value="{{ Auth::user()->username }}">
                </div>
                <div class="mb-4">
                    <label for="message" class="block text-sm text-gray-600 dark:text-gray-400">Message</label>
                    <textarea name="message" id="message" rows="4" class="mt-1 p-2 w-full border rounded-md" required>{{ old('message') }}</textarea>
                </div>
                <div>
                    <button type="submit" class="bg-blue-500 text-white p-2 rounded-md">Send Message</button>
                </div>
            </form>

     
            @if($_SERVER['REQUEST_METHOD'] === 'POST')
                @php
                    $full_name = request('full_name');
                    $contact_number = request('contact_number');
                    $message = request('message');
                @endphp

            
                @php
               
                    session()->flash('success', 'Thank you for contacting us!');
                @endphp
            @endif
        </div>
    </div>
</x-app-layout>