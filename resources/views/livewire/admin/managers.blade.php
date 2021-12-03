<div class="min-w-full px-2 rounded shadow-md">
    <x-table>
        <x-table.header>
            <p class="card-header-title">
                <span class="icon"><i class="mdi mdi-account-group"></i></span>
                Managers
            </p>
            <a href="#" class="card-header-icon">
              Search/perpage/export
            </a>
        </x-table.header>
        <x-slot name="heading">
            <x-table.heading>#</x-table.heading>
            <x-table.heading>Contact</x-table.heading>
            <x-table.heading>Warehouse</x-table.heading>
            <x-table.heading class="flex justify-center">Options</x-table.heading>
        </x-slot>
        @forelse ($managers as $manager)
        <x-table.row class="{{$manager->status==0?'bg-red-300':''}}">
            <x-table.cell data-label="#"> {{$loop->iteration}}</x-table.cell>
            <x-table.cell data-label="Contact">
                <div class="text-sm text-gray-900">{{$manager->name}}</div>
                <div class="text-sm text-gray-500 flex sm:flex-column">
                    <a href="tel:{{$manager->phone}}" class="mr-1">{{$manager->phone}}</a>
                <a href="mailto:{{$manager->email}}">{{$manager->email}}</a></div>
            </x-table.cell>
            <x-table.cell data-label="Warehouse"> 
                @if ($manager->warehouse) {{$manager->warehouse->name}} @endif
            </x-table.cell>
            <x-table.cell data-label="Options" class="flex justify-center"> 
                {{-- <button class="bg-red-300 px-2 py-1" wire:loading.attr="loading" wire:click="delete({{$manager->id}})" 
                onclick="confirm('Are you sure about this?') || event.stopImmediatePropagation();">delete</button>  --}}
                <a class="bg-green-300 px-2 py-1" href="{{ route('admin.managers.single', $manager->id) }}">Edit</a> 
                <button class="bg-oragne-300 px-2 mx-2 py-1" wire:loading.attr="loading" wire:click="block({{$manager->id}})">
                    {{$manager->status?'Block':'Unblock'}}
                </button> 
            </x-table.cell>
        </x-table.row>
        @empty
        <x-table.empty-div></x-table.empty-div>
        @endforelse
    </x-table>
    <x-table.pagination>
    {{$managers->links()}}
    </x-table.pagination>  
    </div>