<div>
    <div class="mt-10 p-5 mx-auto sm:w-full sm:max-w-sm shadow border-teal-500 border-t-2">
        <div class="flex justify-center">
            <h2 class="text-center font-semibold text-2xl text-gray-800 mb-5">Create New Account</h2>
        </div>

        <form wire:submit="createUser" action="#" method="POST" enctype="multipart/form-data" class="space-y-4">
            <!-- Name Field -->
            <div>
                <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Name</label>
                <input type="text" id="name" name="name" placeholder="name.." wire:model="name"
                       class="mt-1 block w-full rounded border-gray-300 bg-gray-100 text-gray-900 text-sm focus:ring-teal-500 focus:border-teal-500">
                @error('name')
                <span class="text-red-500 text-xs">{{ $message }} </span>
                @enderror
            </div>

            <!-- Email Field -->
            <div>
                <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email</label>
                <input type="email" id="email" name="email" placeholder="email.." wire:model="email"
                       class="mt-1 block w-full rounded border-gray-300 bg-gray-100 text-gray-900 text-sm focus:ring-teal-500 focus:border-teal-500">
                @error('email')
                <span class="text-red-500 text-xs">{{ $message }} </span>
                @enderror
            </div>

            <!-- Password Field -->
            <div>
                <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                <input type="password" id="password" name="password" placeholder="password" wire:model="password"
                       class="mt-1 block w-full rounded border-gray-300 bg-gray-100 text-gray-900 text-sm focus:ring-teal-500 focus:border-teal-500">
                @error('password')
                <span class="text-red-500 text-xs">{{ $message }} </span>
                @enderror
            </div>

            <!-- Profile Picture Field -->
            <div>
                <label for="profile_picture" class="block text-sm font-medium leading-6 text-gray-900">Profile
                    Picture</label>
                <input accept="image/png, image.jpeg" type="file" id="profile_picture" name="profile_picture"
                       wire:model="image"
                       class="mt-1 block w-full rounded border-gray-300 text-gray-900 text-sm">
                @error('image')
                <span class="text-red-500 text-xs">{{ $message }} </span>
                @enderror

                @if(!empty($image))
                    <img src="{{$image->temporaryUrl()}}">
                @endif
            </div>

            <!-- Submit Button -->

            <div wire:loading.delay.longest class="text-green-500 text-xs">
                Sending ...
            </div>

            <div>
                <button type="submit" wire:loading.attr="disabled"
                        class="mt-4 w-full bg-teal-500 text-white font-medium py-2 px-4 rounded hover:bg-teal-600 flex justify-center items-center">
                    Create +
                </button>
            </div>
        </form>
    </div>
    @livewire("view-user", ["lazy" => true])
</div>
