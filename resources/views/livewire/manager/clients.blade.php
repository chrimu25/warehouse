<div class="min-w-full px-2 rounded shadow-md">
    <x-table>
        <x-table.header>
            <p class="card-header-title">
                <span class="icon"><i class="mdi mdi-label"></i></span>
                Our Contacts
            </p>
            <div href="#" class="card-header-icon">
                <label for="Search" class="label">Search</label>
                <input class="input" type="search" placeholder="Search..." 
                wire:model.debounce.500="search">
                <div class="flex">
                  <label for="" class="mr-2">Per Page</label>
                  <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 
                    leading-tight focus:outline-none focus:shadow-outline" wire:model.lazy="perPage">
                      <option value="">Per Page</option>
                      <option value="5">5</option>
                      <option value="10">10</option>
                      <option value="25">25</option>
                      <option value="50">50</option>
                  </select>
                </div>
              </div>
        </x-table.header>
        <x-slot name="heading">
            <x-table.heading>#</x-table.heading>
            <x-table.heading>Contact Info</x-table.heading>
            <x-table.heading>Address</x-table.heading>
            <x-table.heading>Invoice</x-table.heading>
            <x-table.heading>Status</x-table.heading>
            <x-table.heading>Options</x-table.heading>
        </x-slot>
        @forelse ($clients as $client)
        <x-table.row>
            <x-table.cell data-label="#"> {{$loop->iteration}}</x-table.cell>
            <x-table.cell data-label="Contact Info">
                <div class="flex items-center sm:flex-column sm:items-start">
                    @if($client->picture)
                    <div class="flex-shrink-0 h-10 w-10">
                      <img class="h-10 w-10 rounded-full" src="{{Storage::url($client->picture)}}" alt="">
                    </div>
                    @endif
                    <div class="ml-4">
                        <span>{{$client->name}}</span>
                        <div class="text-gray-500">
                            <div class="my-1">phone:<span><a href="tel:{{$client->phone}}" class="mr-1">{{$client->phone}}</a></span></div> 
                            <div>Email:<span><a href="mailto:{{$client->email}}">{{$client->email}}</a></span></div> 
                            <div>NID:<span>{{$client->nid}}</span></div> 
                        </div>
                    </div>
                </div>
            </x-table.cell>
            <x-table.cell data-label="Address">
                <div class="text-gray-500">
                    <div class="my-1">District:<span>{{$client->province?$client->province->name:''}}</span></div> 
                    <div>Sector:<span> {{$client->sector?$client->sector->name:''}}</span></div> 
                    <div>Cell:<span> {{$client->cell?$client->cell->name:''}}</span></div> 
                </div>
            </x-table.cell>
            <x-table.cell data-label="Invoice">
                <div class="text-gray-500">
                    <div>Sector:<span> {{$client->sector?$client->sector->name:''}}</span></div> 
                    <div>Cell:<span> {{$client->cell?$client->cell->name:''}}</span></div> 
                </div>
            </x-table.cell>
            <x-table.cell data-label="Status">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                {{$client->status?"bg-green-100 text-green-800":"bg-red-100 text-red-800"}}">
                    {{$client->status?'Active':'Blocked'}}
                  </span>
            </x-table.cell>
            <x-table.cell data-label="Options" class="flex justify-between"> 
                <a href="#!" class="bg-oragne-300 px-2 mx-2 py-1" wire:loading.attr="loading" >
                    View
                </a> 
                <button class="bg-oragne-300 px-2 mx-2 py-1" wire:loading.attr="loading" 
                wire:click="block({{$client->id}})">
                    {{$client->status?'Block':'Unblock'}}
                </button> 
            </x-table.cell>
        </x-table.row>
        @empty
        <x-table.empty-div></x-table.empty-div>
        @endforelse
    </x-table>
    <x-table.pagination>
    {{-- {{$clients->links()}} --}}
    </x-table.pagination>  
    </div>