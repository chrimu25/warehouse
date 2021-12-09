<div>
  <div class="grid gap-6 grid-cols-1 md:grid-cols-3 mb-6">
      <div class="card">
        <div class="card-content">
          <div class="flex items-center justify-between">
            <div class="widget-label">
              <h3>
                All checkouts
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
            <span class="icon widget-icon text-red-500"><i class="mdi mdi-finance mdi-48px"></i></span>
          </div>
        </div>
      </div>
  </div>
  <div class="min-w-full px-2 rounded shadow-md">
      <x-table>
          <x-table.header>
              <p class="card-header-title">
                  <span class="icon"><i class="mdi mdi-label"></i></span>
                  Our Contacts
              </p>
              <div href="#" class="card-header-icon">
                <div class="flex">
                    <label for="" class="mr-2">PerPage</label>
                    <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 
                      leading-tight focus:outline-none focus:shadow-outline" wire:model.lazy="perPage">
                          <option>Per Page</option>
                          <option value="5">5</option>
                          <option value="10">10</option>
                          <option value="25">25</option>
                          <option value="50">50</option>
                    </select>
                </div>
                <div class="flex">
                  <label for="" class="mr-2">Status</label>
                  <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 
                    leading-tight focus:outline-none focus:shadow-outline" wire:model.lazy="status">
                        <option value="">All Status</option>
                        <option value="Pending">Pending</option>
                        <option value="Approved">Approved</option>
                        <option value="Denied">Denied</option>
                  </select>
              </div>
              </div>
          </x-table.header>
          <x-slot name="heading">
              <x-table.heading>#</x-table.heading>
              <x-table.heading>Item</x-table.heading>
              <x-table.heading>Category</x-table.heading>
              <x-table.heading>Warehouse</x-table.heading>
              <x-table.heading>Quantity</x-table.heading>
              <x-table.heading>Date</x-table.heading>
              <x-table.heading>Status</x-table.heading>
              <x-table.heading>Revert</x-table.heading>
          </x-slot>
          @forelse ($checkouts as $item)
          <x-table.row>
              <x-table.cell data-label="#">{{$loop->iteration}}</x-table.cell>
              <x-table.cell data-label="Item">{{$item->product->item->name}}</x-table.cell>
              <x-table.cell data-label="Category">{{$item->product->category->name}}</x-table.cell>
              <x-table.cell data-label="Warehouse">{{$item->warehouse->name}}</x-table.cell>
              <x-table.cell data-label="Quantity">{{$item->quantity}}</x-table.cell>
              <x-table.cell data-label="Date"> {{$item->created_at->format('Y-m-d')}} </x-table.cell>
              <x-table.cell data-label="Status">
                  <span class="inline-flex items-center justify-center 
                  px-2 py-1 text-xs font-bold leading-none text-white 
                  @if($item->status=="Pending") bg-yellow-400 
                  @elseif($item->status=="Approved") bg-green-400 @else 
                  bg-red-400 @endif 
                  rounded-full">{{$item->status}}</span>
              </x-table.cell>
              <x-table.cell data-label="Revert">
                  @if ($item->status=="Pending")
                  <button wire:click="revert({{$item->id}})" wire:loading.attr="disabled">
                      <i class="mdi mdi-undo"></i> Revert
                  </button>
                  @endif
              </x-table.cell>
          </x-table.row>
          @empty
          <x-table.empty-div>8</x-table.empty-div>
          @endforelse
      </x-table>
      <x-table.pagination>
      {{$checkouts->links()}}
      </x-table.pagination>  
      </div>
</div>
