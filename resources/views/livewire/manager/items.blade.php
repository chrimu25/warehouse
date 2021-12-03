<div class="min-w-full px-2 rounded shadow-md">
    <x-table>
        <x-table.header>
            <p class="card-header-title">
                <span class="icon"><i class="mdi mdi-label"></i></span>
                {{$item->name}} Inserted Records ({{$item->stockin->count()}})
            </p>
            <a href="#" class="card-header-icon">
              Search/perpage/export
            </a>
        </x-table.header>
        <x-slot name="heading">
            <x-table.heading>
                <input type="checkbox" wire:model="select_all" id="">
            </x-table.heading>
            <x-table.heading>#</x-table.heading>
            <x-table.heading>Item</x-table.heading>
            <x-table.heading>Owner</x-table.heading>
            <x-table.heading>Date</x-table.heading>
            <x-table.heading>Status</x-table.heading>
            <x-table.heading>Options</x-table.heading>
        </x-slot>
        @forelse ($items as $item)
        <x-table.row>
            <x-table.cell> <input type="checkbox" wire:model="select_single" id=""></x-table.cell>
            <x-table.cell data-label="#"> {{$loop->iteration}}</x-table.cell>
            <x-table.cell data-label="Item">
                <div class="flex items-center sm:flex-column sm:items-start">
                    <div class="text-sm font-medium text-gray-900 block">
                        {{$item->slot->name}}
                    </div> <br>
                    <div class="text-sm text-gray-500">
                        <span class="text-bold">{{$item->quantity}}</span>, {{$item->unity->name}}
                    </div>
                  </div>
            </x-table.cell>
            <x-table.cell data-label="Owner">
                <div class="text-sm text-gray-900">{{$item->owner->name}}</div>
                <div class="text-sm text-gray-500 flex sm:flex-column">
                    <a href="tel:{{$item->owner->phone}}" class="mr-2">{{$item->owner->phone}}</a>
                <a href="mailto:{{$item->owner->email}}">{{$item->owner->email}}</a></div>
            </x-table.cell>
            <x-table.cell data-label="Date"> {{$item->created_at->format('Y-d-m')}} </x-table.cell>
            <x-table.cell data-label="Status">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                @if($item->status=="Pending") bg-yellow-100 text-yellow-800 @elseif($item->status=="Approved") bg-green-100 text-green-800
                 @elseif($item->status=="Denied") bg-red-100 text-red-800 @endif">
                    {{$item->status}}
                  </span>
            </x-table.cell>
            <x-table.cell data-label="Options" class="flex justify-between"> 
                <div class="relative inline-block text-left">
                    <div>
                      <button type="button" class="inline-flex justify-center w-full rounded-md border 
                      border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 
                      hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 
                      focus:ring-offset-gray-100 focus:ring-indigo-500" id="menu-button" 
                      aria-expanded="true" aria-haspopup="true">
                        Options
                        <!-- Heroicon name: solid/chevron-down -->
                        <i class="mdi mdi-chevron-down"></i>
                      </button>
                    </div>
                    <div class="origin-top-right absolute right-0 mt-1 w-56 rounded-md shadow-lg 
                    bg-white ring-1 ring-black ring-opacity-5 focus:outline-none hidden" id="menu-container" role="menu" 
                    aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                      <div class="py-1" role="none">
                        <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
                        <a href="#" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-0">Account settings</a>
                        <a href="#" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-1">Support</a>
                        <a href="#" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-2">License</a>
                      </div>
                    </div>
                  </div>
            </x-table.cell>
        </x-table.row>
        @empty
        <x-table.empty-div></x-table.empty-div>
        @endforelse
    </x-table>
    <x-table.pagination>
    {{$items->links()}}
    </x-table.pagination>  
    </div>