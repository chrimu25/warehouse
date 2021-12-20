<div class="min-w-full px-2 rounded shadow-md">
    <x-table>
        <x-table.header>
            <p class="card-header-title">
                <span class="icon"><i class="mdi mdi-label"></i></span>
                {{$item->name}} Inserted Records ({{$items->count()}})
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
            <x-table.heading>Quantity</x-table.heading>
            <x-table.heading>Owner</x-table.heading>
            <x-table.heading>Date</x-table.heading>
            <x-table.heading>Status</x-table.heading>
            <x-table.heading>Options</x-table.heading>
        </x-slot>
        @forelse ($items as $item)
        <x-table.row>
            <x-table.cell data-label="#"> {{$loop->iteration}}</x-table.cell>
            <x-table.cell data-label="Quantity">
                <div class="flex items-center sm:flex-column sm:items-start">
                    <div class="text-sm text-gray-500">
                        <span class="text-bold">{{$item->quantity}}{{$item->unity?$item->unity->name:''}}</span>
                    </div>
                  </div>
            </x-table.cell>
            <x-table.cell data-label="Owner">
                <div class="text-sm text-gray-900">{{$item->owner?$item->owner->name:''}}</div>
                <div class="text-sm text-gray-500 flex sm:flex-column">
                    <a href="tel:{{$item->owner?$item->owner->phone:''}}" class="mr-2">{{$item->owner?$item->owner->phone:''}}</a>
                <a href="mailto:{{$item->owner?$item->owner->email:''}}">{{$item->owner?$item->owner->email:''}}</a></div>
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
              @if ($item->until->gte(\Carbon\Carbon::now()))  
              <button class="inline-flex justify-center w-full rounded-md border 
              border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 
              hover:bg-gray-50" wire:click="moveOut({{$item->id}})" wire:loading.attr="disabled">
                <span wire:loading.remove>Move Out</span>
                <span wire:loading wire:target="moveOut">Processing</span>
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