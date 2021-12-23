<div class="min-w-full px-2 rounded shadow-md">
    <x-table>
        <x-table.header>
            <p class="card-header-title">
                <span class="icon"><i class="mdi mdi-label"></i></span>
                Store ({{$items->count()}})
            </p>
            <div href="#" class="card-header-icon">
                <div class="flex items-center">
                <label for="Search" class="label mx-2">Search</label>
                <input class="input" type="search" placeholder="Search..." 
                wire:model="searchKey">
                </div>
                <div class="flex items-center">
                  <label for="" class="mx-2 w-full">Per Page</label>
                  <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 
                    leading-tight focus:outline-none focus:shadow-outline" wire:model.lazy="perPage">
                      <option value="">Per Page</option>
                      <option value="10">10</option>
                      <option value="25">25</option>
                      <option value="50">50</option>
                  </select>
                </div>
              </div>
        </x-table.header>
        <x-slot name="heading">
            <x-table.heading>#</x-table.heading>
            <x-table.heading>Item</x-table.heading>
            <x-table.heading>Slot</x-table.heading>
            <x-table.heading>Owner</x-table.heading>
            <x-table.heading>Date</x-table.heading>
            <x-table.heading>Status</x-table.heading>
            <x-table.heading>Options</x-table.heading>
        </x-slot>
        @forelse ($items as $item)
        <x-table.row>
            <x-table.cell data-label="#"> {{$loop->iteration}}</x-table.cell>
            <x-table.cell data-label="Item">
                <div class="text-sm text-gray-900">{{$item->item?$item->item->name:''}}</div>
                <div class="flex items-center sm:flex-column sm:items-start">
                    <div class="text-sm text-gray-500">
                        <span class="text-bold">{{$item->quantity}}{{$item->unity?$item->unity->name:''}}</span>
                    </div>
                  </div>
            </x-table.cell>
            <x-table.cell data-label="Slot">{{$item->slot->exists()?$item->slot->name:''}}</x-table.cell>
            <x-table.cell data-label="Owner">
                @if ($item->owner) 
                <div class="text-sm text-gray-900">
                    <a href="{{route('manager.client', Crypt::encrypt($item->owner->id))}}">
                        {{$item->owner->name}}
                    </a>
                </div>
                <div class="text-sm text-gray-500 flex sm:flex-column">
                    <a href="tel:{{$item->owner->phone}}" class="mr-2">{{$item->owner->phone}}</a>
                <a href="mailto:{{$item->owner->email}}">{{$item->owner->email}}</a></div>
                @endif
            </x-table.cell>
            <x-table.cell data-label="Date"> {{$item->created_at->format('Y-d-m')}} -
                <span @if (\Carbon\Carbon::now()->gte($item->until)) class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                bg-yellow-100 text-yellow-800"@endif> 
                {{$item->until->format('Y-d-m')}} 
            </span>
            </x-table.cell>
            <x-table.cell data-label="Status">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                 bg-green-100 text-green-800">
                    {{$item->status}}
                  </span>
            </x-table.cell>
            <x-table.cell data-label="Options" class="flex justify-between">
                @if (\Carbon\Carbon::createFromFormat('Y-m-d', date('Y-m-d'))->diffInDays(\Carbon\Carbon::createFromFormat('Y-m-d', $item->created_at->format('Y-m-d'))) >= 3)
                    
                <button class="block px-4 mr-1 rounded w-full text-sm capitalize  
                    bg-gray-200 hover:bg-gray-100 text-gray-900" wire:click="invoice({{$item->id}})" 
                    wire:loading.attr="disabled">Invoice
                </button>  
                <button class="block px-4 rounded w-full text-sm capitalize  
                    bg-blue-200 text-blue-900 hover:bg-blue-100" wire:click="moveOut({{$item->id}})" 
                    wire:loading.attr="disabled">Move Out
                </button>
                @endif 
            </x-table.cell>
        </x-table.row>
        @empty
        <x-table.empty-div>7</x-table.empty-div>
        @endforelse
    </x-table>
    <x-table.pagination>
    {{$items->links()}}
    </x-table.pagination>  
</div>