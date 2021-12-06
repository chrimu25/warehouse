<div class="min-w-full px-2 rounded shadow-md">
    <x-table>
        <x-table.header>
            <p class="card-header-title">
                <span class="icon"><i class="mdi mdi-label"></i></span>
                Our Contacts
            </p>
            <a href="#" class="card-header-icon">
              Search/perpage/export
            </a>
        </x-table.header>
        <x-slot name="heading">
            <x-table.heading>
                <input type="checkbox" wire:model="select_all" id="">
            </x-table.heading>
            <x-table.heading>#</x-table.heading>
            <x-table.heading>Item</x-table.heading>
            <x-table.heading>Quantity</x-table.heading>
            <x-table.heading>Warehouse</x-table.heading>
            <x-table.heading>Slot</x-table.heading>
            <x-table.heading>Manager</x-table.heading>
            <x-table.heading>Actions</x-table.heading>
        </x-slot>
        {{-- @forelse ($clients as $client) --}}
        <x-table.row>
            <x-table.cell> <input type="checkbox" wire:model="select_single" id=""></x-table.cell>
            <x-table.cell data-label="#"> </x-table.cell>
            <x-table.cell data-label="Contact Info">
                <div class="flex items-center sm:flex-column sm:items-start">
                    <div class="ml-4">
                        <span>Soya</span>
                        <div class="text-gray-500">
                           <div class="my-1">From:<span>20/12/2020</span></div> 
                           <div>To:<span>20/12/2020</span></div> 
                        </div>
                    </div>
                </div>
            </x-table.cell>
            <x-table.cell data-label="Address">
                23000 Kgs
            </x-table.cell>
            <x-table.cell data-label="Contact Info">
                <div class="flex items-center sm:flex-column sm:items-start">
                    <div class="ml-4">
                        <span>Magerwa SL</span>
                        <div class="text-gray-500">
                            <div class="my-1">Province:<span>20/12/2020</span></div> 
                            <div>District:<span>20/12/2020</span></div> 
                        </div>
                    </div>
                </div>
            </x-table.cell>
            <x-table.cell data-label="Status">
                Slot002
            </x-table.cell>
            <x-table.cell data-label="Contact">
                <div class="text-sm text-gray-900">Issa BIGIRIMANA</div>
                <div class="text-gray-500">
                    <div class="my-1">Phone:<span>20/12/2020</span></div> 
                    <div>Email:<span>20/12/2020</span></div> 
                 </div>
            </x-table.cell>
            <x-table.cell data-label="Options" class="flex justify-between bg-gray-300"> 
                <div x-data="{ dropdownOpen: false }" class="relative">
                    <button @click="dropdownOpen = !dropdownOpen" class="relative z-10 block rounded-md 
                    bg-white p-2 flex justify-between focus:outline-none">
                      Options <i class="mdi mdi-chevron-down"></i>
                    </button>
                  
                    <div x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 h-full w-full z-10"></div>
                  
                    <div x-show="dropdownOpen" class="absolute right-0 mt-2 py-2 w-48 bg-white rounded-md shadow-xl z-20">
                      <a href="#" class="block px-4 py-2 text-sm capitalize text-gray-700 hover:bg-blue-500 hover:text-white">
                        Checkin
                      </a>
                      <a href="#" class="block px-4 py-2 text-sm capitalize text-gray-700 hover:bg-blue-500 hover:text-white">
                        Checkout
                      </a>
                    </div>
                  </div>
            </x-table.cell>
        </x-table.row>
        {{-- @empty --}}
        <x-table.empty-div></x-table.empty-div>
        {{-- @endforelse --}}
    </x-table>
    <x-table.pagination>
    {{-- {{$clients->links()}} --}}
    </x-table.pagination>  
    </div>