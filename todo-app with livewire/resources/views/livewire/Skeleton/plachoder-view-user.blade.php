<div wire:poll.visible.5s>
    <div class="container mx-auto mt-10">
        <h1 class="text-2xl font-semibold text-gray-800 mb-5">User List</h1>
        <div class="bg-white shadow-md rounded">
            <!-- Skeleton khi dữ liệu đang tải -->
            <table class="min-w-full bg-white">
                <thead>
                <tr>
                    <th class="py-3 px-6 bg-gray-200 text-gray-600 text-left text-sm uppercase font-medium">Name</th>
                    <th class="py-3 px-6 bg-gray-200 text-gray-600 text-left text-sm uppercase font-medium">Email</th>
                    <th class="py-3 px-6 bg-gray-200 text-gray-600 text-left text-sm uppercase font-medium">Created At</th>
                </tr>
                </thead>
                <tbody>
                @for ($i = 0; $i < 2; $i++)
                    <tr class="border-b">
                        <td class="py-3 px-6 text-sm">
                            <div class="h-4 bg-gray-300 rounded w-3/4 animate-pulse"></div>
                        </td>
                        <td class="py-3 px-6 text-sm">
                            <div class="h-4 bg-gray-300 rounded w-2/4 animate-pulse"></div>
                        </td>
                        <td class="py-3 px-6 text-sm">
                            <div class="h-4 bg-gray-300 rounded w-1/4 animate-pulse"></div>
                        </td>
                    </tr>
                @endfor
                </tbody>
            </table>
        </div>
        <div class="bg-white shadow-md rounded">
            <div class="flex items-center justify-between pt-4">
                <div>
                    <div class="h-2.5 bg-gray-300 rounded-full w-32 mb-2.5"></div>
                </div>
                <div>
                    <div class="h-2.5 bg-gray-300 rounded-full w-96 mb-2.5"></div>
                </div>
            </div>
        </div>
    </div>
</div>
