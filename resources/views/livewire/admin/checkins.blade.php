<div>
    <div class="md:flex justify-between mb-6">
        <div class="card w-full mx-1">
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
        <div class="card w-full mx-1">
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
        <div class="card w-full mx-1">
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
        <div class="card w-full mx-1">
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
    </div>
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
                      leading-tight focus:outline-none focus:shadow-outline" wire:model.lazy="status">
                        <option value="">Default</option>
                        <option value="Pending">Pending</option>
                        <option value="Approved">Approved</option>
                        <option value="Denied">Denied</option>
                    </select>
                  </div>
                </div>
            </x-table.header>
            <x-slot name="heading">
                <x-table.heading>#</x-table.heading>
                <x-table.heading>Client</x-table.heading>
                <x-table.heading>Warehouse</x-table.heading>
                <x-table.heading>Date</x-table.heading>
                <x-table.heading>Status</x-table.heading>
            </x-slot>
            @forelse ($items as $item)
            <x-table.row>
                <x-table.cell data-label="#"> {{$loop->iteration}}</x-table.cell>
                <x-table.cell data-label="Client">
                    <span>{{$item->user->name}}</span>
                    <div class="text-gray-500">
                    <div>Contact:<a href="tel:{{$item->user_id?$item->user->phone:''}}" class="mr-2">{{$item->user_id?$item->user->phone:''}}</a></div> 
                    <div>Item:<span>{{$item->quantity.$item->product->unity->name.__(' of ').$item->product->item->name}}</span></div>
                    </div> 
                </x-table.cell>
                <x-table.cell data-label="Warehouse">
                    <span>{{$item->warehouse_id?$item->warehouse->name:''}}</span>
                    <div class="text-gray-500">
                        <div>Incharge:<span>{{$item->warehouse_id?$item->warehouse->manager->name:''}}</span></div> 
                        <div class="my-1">Location:<span>{{$item->warehouse_id?$item->warehouse->district->name:''}}, {{$item->warehouse_id?$item->warehouse->sector->name:''}}</span></div> 
                    </div>
                </x-table.cell>
                <x-table.cell data-label="Date"> {{$item->created_at->format('Y-d-m')}}
                </span>
                </x-table.cell>
                <x-table.cell data-label="Status">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                     @if($item->status=="Approved") 
                     bg-green-100 text-green-800 @elseif($item->status=="Pending") 
                     bg-yellow-100 text-yellow-800 
                     @else bg-red-100 text-red-800 @endif">
                        {{$item->status}}
                      </span>
                </x-table.cell>
            </x-table.row>
            @empty
            <x-table.empty-div>6</x-table.empty-div>
            @endforelse
        </x-table>
        <x-table.pagination>
        {{$items->links()}}
        </x-table.pagination>  
    </div>
</div>

