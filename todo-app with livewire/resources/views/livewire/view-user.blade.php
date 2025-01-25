<div >
    <div class="container mx-auto mt-10">
        <h1 class="text-2xl font-semibold text-gray-800 mb-5">User List</h1>
        <div class="bg-white shadow-md rounded">
            <table class="min-w-full bg-white">
                <thead>
                <tr>
                    <th class="py-3 px-6 bg-gray-200 text-gray-600 text-left text-sm uppercase font-medium">Name</th>
                    <th class="py-3 px-6 bg-gray-200 text-gray-600 text-left text-sm uppercase font-medium">Email</th>
                    <th wire:click="$refresh" class="py-3 px-6 bg-gray-200 text-gray-600 text-left text-sm uppercase font-medium">Created At</th>
                    <th class="py-3 px-6 bg-gray-200 text-gray-600 text-left text-sm uppercase font-medium"></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($this->users as $user)
                    <tr class="border-b hover:bg-gray-100">
                        <td class="py-3 px-6 text-sm text-gray-700">{{ $user->name }}</td>
                        <td class="py-3 px-6 text-sm text-gray-700">{{ $user->email }}</td>
                        <td class="py-3 px-6 text-sm text-gray-700">{{ $user->created_at->format('Y-m-d') }}</td>
                        <td>
                            <button wire:click="$parent.removeUser({{$user->id}})">Delete</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $this->users->links() }}
        </div>
    </div>
</div>
