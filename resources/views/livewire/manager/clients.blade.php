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
            <x-table.heading>Contact Info</x-table.heading>
            <x-table.heading>Address</x-table.heading>
            <x-table.heading>National ID</x-table.heading>
            <x-table.heading>Status</x-table.heading>
            <x-table.heading>Options</x-table.heading>
        </x-slot>
        @forelse ($clients as $client)
        <x-table.row>
            <x-table.cell> <input type="checkbox" wire:model="select_single" id=""></x-table.cell>
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
                        <div class="text-gray-500 flex sm:flex-column">
                            <a href="tel:{{$client->phone}}" class="mr-1">{{$client->phone}}</a>
                            <a href="mailto:{{$client->email}}">{{$client->email}}</a>
                        </div>
                    </div>
                </div>
            </x-table.cell>
            <x-table.cell data-label="Address">
                <div class="text-sm font-medium text-gray-900">
                    {{-- {{$client->district->name}}, {{$client->sector->name}}, {{$client->cell->name}} --}}
                </div>
            </x-table.cell>
            <x-table.cell data-label="National ID"> {{$client->nid}} </x-table.cell>
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