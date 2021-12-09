<div class="min-w-full px-2 rounded shadow-md">
    <x-table>
        <x-table.header>
            <p class="card-header-title">
                <span class="icon"><i class="mdi mdi-label"></i></span>
                My Requests
            </p>
            <div href="#" class="card-header-icon">
              Search/perpage/export
            </div>
        </x-table.header>
        <x-slot name="heading">
            <x-table.heading>#</x-table.heading>
            <x-table.heading>Item</x-table.heading>
            <x-table.heading>Quantity</x-table.heading>
            <x-table.heading>Warehouse</x-table.heading>
            <x-table.heading>Slot</x-table.heading>
            <x-table.heading>Manager</x-table.heading>
            <x-table.heading>Actions</x-table.heading>
        </x-slot>
        @forelse ($items as $item)
        <x-table.row>
            <x-table.cell data-label="#">{{$loop->iteration}}</x-table.cell>
            <x-table.cell data-label="Item">
                <div class="flex items-center sm:flex-column sm:items-start">
                    <div class="ml-4">
                        <span>{{$item->item->name}}</span>
                        <div class="text-gray-500">
                           <div class="my-1">From:<span>{{$item->created_at->format('Y-m-d')}}</span></div> 
                           <div>To:<span>{{$item->until->format('Y-m-d')}}</span></div> 
                        </div>
                    </div>
                </div>
            </x-table.cell>
            <x-table.cell data-label="Quantity">
                {{$item->quantity}} 
                {{$item->unity->name}}
            </x-table.cell>
            <x-table.cell data-label="Warehouse">
                <div class="flex items-center sm:flex-column sm:items-start">
                    <div class="ml-4">
                        <span>{{$item->warehouse->name}}</span>
                        <div class="text-gray-500">
                            <div class="my-1">Province:<span>{{$item->warehouse->province->name}}</span></div> 
                            <div>District:<span>{{$item->warehouse->district->name}}</span></div> 
                        </div>
                    </div>
                </div>
            </x-table.cell>
            <x-table.cell data-label="Slot">
                {{$item->slot->name}}
            </x-table.cell>
            <x-table.cell data-label="Manager">
                <div class="text-sm text-gray-900">{{$item->warehouse->manager->name}}</div>
                <div class="text-gray-500">
                    <div class="my-1">Phone: <a href="tel:+{{$item->warehouse->manager->phone}}">{{$item->warehouse->manager->phone}}</a></div> 
                    <div>Email: <a href="mailto:{{$item->warehouse->manager->email}}">{{$item->warehouse->manager->email}}</a></div> 
                 </div>
            </x-table.cell>
            <x-table.cell data-label="Actions" class="flex justify-between"> 
                <div x-data="{ dropdownOpen: false }" class="relative">
                    <button @click="dropdownOpen = !dropdownOpen" class="relative z-10 block rounded-md 
                    bg-white p-2 flex justify-between focus:outline-none bg-gray-800 text-white">
                      Options <i class="mdi mdi-chevron-down"></i>
                    </button>
                  
                    <div x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 h-full w-full z-10"></div>
                  
                    <div x-show="dropdownOpen" class="absolute right-0 mt-2 py-2 w-48 bg-white rounded-md shadow-xl z-20">
                      <a href="{{ route('client.items.checkin',$item->id) }}" class="block px-4 py-2 text-sm capitalize text-gray-700 
                      hover:bg-blue-500 hover:text-white">
                        Checkin
                      </a>
                      <a href="{{ route('client.items.checkout',$item->id) }}" class="block px-4 py-2 text-sm capitalize text-gray-700 
                      hover:bg-blue-500 hover:text-white">
                        Checkout
                      </a>
                      <a href="{{ route('client.items.transfer',$item->id) }}" class="block px-4 py-2 text-sm capitalize text-gray-700 
                        hover:bg-blue-500 hover:text-white">
                          Transfer
                        </a>
                    </div>
                </div>
            </x-table.cell>
        </x-table.row>
        @empty
        <x-table.empty-div>8</x-table.empty-div>
        @endforelse
    </x-table>
    <x-table.pagination>
    {{$items->links()}}
    </x-table.pagination>  
    </div>