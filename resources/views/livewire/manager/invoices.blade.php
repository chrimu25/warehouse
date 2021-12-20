<div>
    {{-- <div class="grid gap-3 grid-cols-2 md:grid-cols-3 mb-6">
        <div class="card">
          <div class="card-content">
            <div class="flex items-center justify-between">
              <div class="widget-label">
                <h3>
                  All Requests
                </h3>
                <h1>
                  {{$all}}
                </h1>
              </div>
              <span class="icon widget-icon text-green-500"><i class="mdi mdi-account-multiple mdi-48px"></i></span>
            </div>
          </div>
        </div>
        <div class="card">
            <div class="card-content">
              <div class="flex items-center justify-between">
                <div class="widget-label">
                  <h3>
                    Pending
                  </h3>
                  <h1>
                    {{$pending}}
                  </h1>
                </div>
                <span class="icon widget-icon text-green-500"><i class="mdi mdi-account-multiple mdi-48px"></i></span>
              </div>
            </div>
          </div>
        <div class="card">
          <div class="card-content">
            <div class="flex items-center justify-between">
              <div class="widget-label">
                <h3>
                  Approved
                </h3>
                <h1>
                  {{$approved}}
                </h1>
              </div>
              <span class="icon widget-icon text-blue-500"><i class="mdi mdi-cart-outline mdi-48px"></i></span>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-content">
            <div class="flex items-center justify-between">
              <div class="widget-label">
                <h3>
                  Denied
                </h3>
                <h1>
                  {{$denied}}
                </h1>
              </div>
              <span class="icon widget-icon text-blue-500"><i class="mdi mdi-cart-outline mdi-48px"></i></span>
            </div>
          </div>
        </div>
    </div> --}}
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
                  <div class="flex items-center">
                    <label for="" class="mx-2">Status</label>
                    <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 
                      leading-tight focus:outline-none focus:shadow-outline" wire:model.lazy="confirmed">
                        <option value="">Default</option>
                        <option value="1">Confirmed</option>
                        <option value="0">Pending</option>
                    </select>
                  </div>
                </div>
                <div href="#" class="card-header-icon">
                </div>
            </x-table.header>
            <x-slot name="heading">
                <x-table.heading>#</x-table.heading>
                <x-table.heading>Invoice</x-table.heading>
                <x-table.heading>Owner</x-table.heading>
                <x-table.heading>Item</x-table.heading>
                <x-table.heading>Days</x-table.heading>
                <x-table.heading>Total Price</x-table.heading>
                <x-table.heading>Options</x-table.heading>
            </x-slot>
            @forelse ($items as $item)
            <x-table.row>
                <x-table.cell data-label="#"> {{$loop->iteration}}</x-table.cell>
                <x-table.cell data-label="Invoice">
                    {{$item->code}}
                </x-table.cell>
                <x-table.cell data-label="Owner">
                    <div class="text-sm text-gray-900">{{$item->owner?$item->owner->name:''}}</div>
                    <div class="text-sm text-gray-500 flex sm:flex-column">
                        <a href="tel:{{$item->owner?$item->owner->phone:''}}" class="mr-2">{{$item->owner?$item->owner->phone:''}}</a>
                    <a href="mailto:{{$item->owner?$item->owner->email:''}}">{{$item->owner?$item->owner->email:''}}</a></div>
                </x-table.cell>
                <x-table.cell data-label="Item"> {{$item->product?$item->product->item->name:''}}
                </x-table.cell>
                <x-table.cell data-label="Days"> {{$item->days}}
                </x-table.cell>
                <x-table.cell data-label="Total Price"> {{$item->total_price}}
                </x-table.cell>
                <x-table.cell data-label="Options" class="flex justify-between"> 
                    @if (!$item->confirmed)
                    <button class="block mr-1 px-4 py-1 w-full text-sm capitalize text-gray-700 bg-green-300
                        rounded hover:bg-green-200 hover:text-white" wire:click="confirm({{$item->id}})" 
                        wire:loading.attr="disabled">Confirm
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
</div>
