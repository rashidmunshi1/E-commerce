<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Picture') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Update your profile picture.') }}
        </p>
    </header>

    <form method="POST" action="{{ route('profile.update-picture') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('PATCH')

        <!-- Display Profile Picture -->
        <div>
            <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('default-avatar.png') }}"
                alt="Profile Picture" class="w-32 h-32 rounded-full object-cover">
        </div>

        <!-- Upload New Picture -->
        <div>
            <label for="profile_picture" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                {{ __('Upload a new picture') }}
            </label>
            <input type="file" name="profile_picture" id="profile_picture" class="mt-1 block w-full text-sm text-gray-600 dark:text-gray-300">
            @error('profile_picture')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Save Button -->
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    </form>
</section>
