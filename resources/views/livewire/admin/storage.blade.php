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
                    <label for="" class="mx-2 w-full ">Per Page</label>
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
                <div class="flex items-center">
                    <label for="" class="mx-2 w-full">Moved In/Out</label>
                    <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 
                    leading-tight focus:outline-none focus:shadow-outline" wire:model.lazy="inStore">
                        <option value="0">In</option>
                        <option value="1">Out</option>
                    </select>
                </div>
                </div>
            </x-table.header>
            <x-slot name="heading">
                <x-table.heading>#</x-table.heading>
                <x-table.heading>Item</x-table.heading>
                <x-table.heading>Owner</x-table.heading>
                <x-table.heading>Warehouse</x-table.heading>
                <x-table.heading>Date</x-table.heading>
                <x-table.heading>Status</x-table.heading>
            </x-slot>
            @forelse ($items as $item)
            <x-table.row>
                <x-table.cell data-label="#"> {{$loop->iteration}}</x-table.cell>
                <x-table.cell data-label="Item">
                    <div class="text-sm text-gray-900">{{$item->item->name}}</div>
                    <div class="flex items-center sm:flex-column sm:items-start">
                        <div class="text-sm text-gray-500">
                            <span class="text-bold">{{$item->quantity}}{{$item->unity->name}}</span>
                        </div>
                    </div>
                </x-table.cell>
                <x-table.cell data-label="Owner">
                    <div class="flex items-center sm:flex-column sm:items-start">
                        <div class="ml-4">
                            <span>{{$item->owner->exists()?$item->owner->name:''}}</span>
                            <div class="text-gray-500">
                                <div class="my-1">Email:<a href="mailto:{{$item->owner->exists()?$item->owner->email:''}}">{{$item->owner->exists()?$item->owner->email:''}}</a></div> 
                                <div>Phone:<a href="tel:{{$item->owner->exists()?$item->owner->phone:''}}" class="mr-2">{{$item->owner->exists()?$item->owner->phone:''}}</a></div> 
                            </div>
                        </div>
                    </div>
                </x-table.cell>
                <x-table.cell data-label="Warehouse">
                    <div class="flex items-center sm:flex-column sm:items-start">
                    <div class="ml-4">
                        <span>{{$item->warehouse?$item->warehouse->name:''}}</span>
                        <div class="text-gray-500">
                            <div class="my-1">Location:<span>{{$item->warehouse->exists()?$item->warehouse->district->name:''}}</span></div> 
                            <div>Slot:<span>{{$item->slot->exists()?$item->slot->name:''}}</span></div> 
                        </div>
                    </div>
                    </div>
                </x-table.cell>
                <x-table.cell data-label="Date"> 
                    <div class="flex items-center sm:flex-column sm:items-start">
                        <div class="ml-4">
                            <div>Incharge:<span>{{$item->incharge1?$item->incharge1->name:''}}</span></div> 
                            <div class="text-gray-500">
                            <div class="my-1">From:<span>{{$item->created_at->format('Y-d-m')}}</span></div> 
                            <div>Until:<span @if (\Carbon\Carbon::now()->gte($item->until)) class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                bg-yellow-100 text-yellow-800"@endif> 
                                {{$item->until->format('Y-d-m')}} 
                                </span></div>
                            </div>
                        </div>
                    </div>
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
        {{$items->links()}}
        </x-table.pagination>  
    </div>
</div>