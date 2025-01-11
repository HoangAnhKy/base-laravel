
    <div id="content" class="mx-auto" style="max-width:500px;">
        <div class="container content py-6 mx-auto">
            <div class="mx-auto">
            </div>
        </div>
        @include('livewire.ToDo.include.create-todo-list')
        @include('livewire.ToDo.include.search-box')

        <div id="todos-list">

            @forelse($todos as $todo)
                @include("livewire.ToDo.include.card-todo")
            @empty
                <span class="text-red-500 text-xs block mt-2">Empty data</span>
            @endforelse


            <div class="my-2">
               @if(!empty($todos))
                    {{ $todos->links() }}
               @endif
            </div>
        </div>
    </div>
