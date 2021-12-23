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
                    Invoices ({{$items->count()}})
                </p>
                <div href="#" class="card-header-icon">
                  <label for="Search" class="label">Search</label>
                  <input class="input" type="search" placeholder="Search..." 
                  wire:model="searchKey">
                  <div class="flex">
                    <label for="" class="mr-2">Per Page</label>
                    <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 
                      leading-tight focus:outline-none focus:shadow-outline" wire:model.lazy="perPage">
                        <option value="">Per Page</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                  </div>
                  <div class="flex">
                    <label for="" class="mr-2">Status</label>
                    <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 
                      leading-tight focus:outline-none focus:shadow-outline" wire:model.lazy="confirmed">
                        <option value="">Default</option>
                        <option value="1">Confirmed</option>
                        <option value="0">Pending</option>
                    </select>
                  </div>
                </div>
            </x-table.header>
            <x-slot name="heading">
                <x-table.heading>#</x-table.heading>
                <x-table.heading>Invoice</x-table.heading>
                <x-table.heading>Warehouse</x-table.heading>
                <x-table.heading>Item</x-table.heading>
                <x-table.heading>Price/Day</x-table.heading>
                <x-table.heading>Days</x-table.heading>
                <x-table.heading>Total Price</x-table.heading>
                <x-table.heading>Status</x-table.heading>
            </x-slot>
            @forelse ($items as $item)
            <x-table.row>
                <x-table.cell data-label="#"> {{$loop->iteration}}</x-table.cell>
                <x-table.cell data-label="Invoice">
                    {{$item->code}}
                </x-table.cell>
                <x-table.cell data-label="Warehouse">
                    <div class="text-sm text-gray-900">{{$item->warehouse?$item->warehouse->name.', '.$item->warehouse->code:''}}</div>
                    <div class="text-gray-500">
                        <div class="my-1">Slot: {{$item->product->slot?$item->product->slot->name:''}}</div> 
                    </div>
                </x-table.cell>
                <x-table.cell data-label="Item"> 
                    <div class="text-sm text-gray-900">{{$item->product?$item->product->item->name:''}}</div>
                    <div class="text-gray-500">
                        {{$item->product?$item->product->quantity.$item->product->unity->name:''}} 
                    </div>
                </x-table.cell>
                <x-table.cell data-label="Price/Day">
                    {{$item->product->slot?$item->product->slot->price:''}}
                </x-table.cell>
                <x-table.cell data-label="Days"> {{$item->days}}
                </x-table.cell>
                <x-table.cell data-label="Total Price"> {{$item->total_price}}
                </x-table.cell>
                <x-table.cell data-label="Status">
                  <span class="inline-flex items-center justify-center 
                  px-2 py-1 text-xs font-bold leading-none  
                  @if($item->confirmed) bg-green-100 text-green-900 @else 
                  bg-red-100 text-red-900 @endif  rounded-full">{{$item->confirmed?"Confirmed":'Pending'}}</span>
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
