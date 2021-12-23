<div>
  <div class="md:flex justify-between mb-6">
    <div class="card w-full mx-1">
      <div class="card-content">
        <div class="flex items-center justify-between">
          <div class="widget-label">
            <h3>
              All Outgoing Transfers
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
                    Store ({{$transfers->count()}})
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
                        <option value="Denied">Denied</option>
                    </select>
                  </div>
                </div>
            </x-table.header>
            <x-slot name="heading">
                <x-table.heading>#</x-table.heading>
                <x-table.heading>Item</x-table.heading>
                <x-table.heading>Owner</x-table.heading>
                <x-table.heading>To</x-table.heading>
                <x-table.heading>Invoice</x-table.heading>
                <x-table.heading>Options</x-table.heading>
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
                            <div>Until:<span class="ml-1">{{$item->until->format('Y-d-m')}}</span></div> 
                        </div>
                    </div>
                  </div>
                </x-table.cell>
                <x-table.cell data-label="Owner">
                  @if ($item->owner1)
                  <div class="flex items-center sm:flex-column sm:items-start">
                    <div class="ml-4">
                        <span>
                          <a href="{{route('manager.client', Crypt::encrypt($item->owner1->id))}}">
                          {{$item->owner1->name}}
                          </a>
                        </span>
                        <div class="text-gray-500">
                            <div class="my-1">phone:<span><a href="tel:{{$item->owner1->phone}}" class="mr-2">{{$item->owner1->phone}}</a></span></div> 
                            <div>Email:<span><a href="mailto:{{$item->owner1->email}}">{{$item->owner1->email}}</a></span></div> 
                        </div>
                    </div>
                  </div>
                  @endif
                </x-table.cell>
                <x-table.cell data-label="From">
                  <div class="flex items-center sm:flex-column sm:items-start">
                    <div class="ml-4">
                        <span>{{$item->toWarehouse?$item->toWarehouse->name:''}}</span>
                        <div class="text-gray-500">
                            <div class="my-1">Province:<span>{{$item->toWarehouse?$item->toWarehouse->province->name:''}}</span></div> 
                            <div>District:<span>{{$item->toWarehouse?$item->toWarehouse->district->name:''}}</span></div> 
                        </div>
                    </div>
                  </div>
                </x-table.cell>
                <x-table.cell data-label="Invoice"></x-table.cell>
                <x-table.cell data-label="Options" class="flex justify-between"> 
                    @if($item->approved==0)
                    <button class="block mr-1 px-4 py-1 w-full text-sm capitalize text-gray-700 bg-green-300
                        rounded hover:bg-green-200 hover:text-white" wire:click="Approve({{$item->id}})" 
                        wire:loading.attr="disabled">
                        Approve
                    </button>
                    <button class="block px-4 py-1 w-full text-sm capitalize text-gray-700 bg-red-300
                      rounded hover:bg-red-200 hover:text-white" wire:click="delete({{$item->id}})" 
                      wire:loading.attr="disabled">
                      Delete
                    </button>
                    @endif
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
