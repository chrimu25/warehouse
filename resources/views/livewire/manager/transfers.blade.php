<div>
    <div class="grid gap-3 grid-cols-2 md:grid-cols-3 mb-6">
        <div class="card">
          <div class="card-content">
            <div class="flex items-center justify-between">
              <div class="widget-label">
                <h3>
                  All Transfers
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
                  {{$denied}}
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
    </div>
    <div class="min-w-full px-2 rounded shadow-md">
        <x-table>
            <x-table.header>
                <p class="card-header-title">
                    <span class="icon"><i class="mdi mdi-label"></i></span>
                    Store ({{$transfers->count()}})
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
                      leading-tight focus:outline-none focus:shadow-outline" wire:model.lazy="status">
                        <option value="">Default</option>
                        <option value="Pending">Pending</option>
                        <option value="Denied">Denied</option>
                    </select>
                  </div>
                </div>
            </x-table.header>
            <x-slot name="heading">
                <x-table.heading>#</x-table.heading>
                <x-table.heading>Item</x-table.heading>
                <x-table.heading>Owner</x-table.heading>
                <x-table.heading>From</x-table.heading>
                <x-table.heading>To</x-table.heading>
                <x-table.heading>Status</x-table.heading>
            </x-slot>
            @forelse ($transfers as $item)
            <x-table.row>
                <x-table.cell data-label="#"> {{$loop->iteration}}</x-table.cell>
                <x-table.cell data-label="Item">
                  <div class="flex items-center sm:flex-column sm:items-start">
                    <div class="ml-4">
                        <span>{{$item->product()->exists()?$item->product->item->name:''}}</span>
                        <div class="text-gray-500">
                            <div class="my-1">Quantity:<span class="ml-1">{{$item->quantity}}{{$item->unity()->exists()?$item->unity->name:''}}</span></div> 
                        </div>
                    </div>
                  </div>
                </x-table.cell>
                <x-table.cell data-label="Owner">
                  <div class="flex items-center sm:flex-column sm:items-start">
                    <div class="ml-4">
                        <span>{{$item->owner1?$item->owner1->name:''}}</span>
                        <div class="text-gray-500">
                            <div class="my-1">phone:<span><a href="tel:{{$item->owner1?$item->owner1->phone:''}}" class="mr-2">{{$item->owner1?$item->owner1->phone:''}}</a></span></div> 
                            <div>Email:<span><a href="mailto:{{$item->owner1?$item->owner1->email:''}}">{{$item->owner1?$item->owner1->email:''}}</a></span></div> 
                        </div>
                    </div>
                  </div>
                </x-table.cell>
                <x-table.cell data-label="From">
                  <div class="flex items-center sm:flex-column sm:items-start">
                    <div class="ml-4">
                        <span>{{$item->fromWarehouse?$item->fromWarehouse->name:''}}</span>
                        <div class="text-gray-500">
                            <div class="my-1">Province:<span>{{$item->fromWarehouse?$item->fromWarehouse->province->name:''}}</span></div> 
                            <div>District:<span>{{$item->fromWarehouse?$item->fromWarehouse->district->name:''}}</span></div> 
                        </div>
                    </div>
                  </div>
                </x-table.cell>
                <x-table.cell data-label="To">
                  {{$item->slot->exists()?$item->slot->name:''}}
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
            <x-table.empty-div>7</x-table.empty-div>
            @endforelse
        </x-table>
        <x-table.pagination>
        {{$transfers->links()}}
        </x-table.pagination>  
    </div>
</div>
