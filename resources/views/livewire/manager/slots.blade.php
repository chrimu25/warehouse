<div class="grid grid-cols-3 gap-4 w-full p-2">
    <div class="col-span-2 bg-white shadow-sm py-2 px-4 rounded ">
      <x-table>
        <x-table.header>
          <p class="card-header-title">
            <span class="icon"><i class="mdi mdi-label"></i></span>
            Slots
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
          </div>
        </x-table.header>
        <x-slot name="heading">
          <x-table.heading>#</x-table.heading>
          <x-table.heading>Name</x-table.heading>
          <x-table.heading>Category</x-table.heading>
          <x-table.heading>Price</x-table.heading>
          <x-table.heading>Size (m2)</x-table.heading>
          <x-table.heading>Options</x-table.heading>
        </x-slot>
        @forelse ($slots as $slot)
        <x-table.row>
          <x-table.cell data-label="#"> {{$loop->iteration}}</x-table.cell>
          <x-table.cell data-label="Name"> {{$slot->name}}</x-table.cell>
          <x-table.cell data-label="Category"> {{$slot->category?$slot->category->name:''}} </x-table.cell>
          <x-table.cell data-label="Price"> {{$slot->price}} </x-table.cell>
          <x-table.cell data-label="Size">{{$slot->size}}</x-table.cell>
          <x-table.cell data-label="Options" class="flex justify-between">
              <button class="bg-red-300 px-2 py-1" wire:loading.attr="loading" wire:click="delete({{$slot->id}})"
                onclick="confirm('Are you sure about this?') || event.stopImmediatePropagation();">delete</button>
              <button class="bg-green-300 px-2 py-1" wire:click="edit({{$slot->id}})">Edit</button>
            </x-table.cell>
        </x-table.row>
        @empty
        <x-table.empty-div> 7 </x-table.empty-div>
        @endforelse
      </x-table>
      <x-table.pagination>
        {{$slots->links()}}
      </x-table.pagination>
    </div>
    <div class="bg-white shadow-sm py-2 px-4 rounded ">
      <div class="sm:mt-0">
          <div class="md:mt-0">
            @if (!$open)
            <h3 class="text-2xl font-bold">Insert New Slot</h3>
            <form wire:submit.prevent="store" method="POST">
                @csrf
                <div class="py-5 bg-white ">
                    <x-jet-label for="size" value="{{ __('Slot Size') }}" />
                    <x-jet-input id="size" type="number" class="mt-1 w-full"
                      wire:model.defer="size" autocomplete="size" />
                    <x-jet-input-error for="size" class="mt-2" />
                </div>
                <div class="py-5 bg-white ">
                  <x-jet-label for="price" value="{{ __('Price/Day') }}" />
                  <x-jet-input id="price" type="number" class="mt-1 w-full"
                    wire:model.defer="price" autocomplete="price" />
                  <x-jet-input-error for="price" class="mt-2" />
                </div>
                <div class="field">
                <label for="unity" class="label">Category</label>
                <div class="select">
                    <select name="unity" wire:model="category">
                        <option value="">-- Category --</option>
                        @forelse ($categories as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                        @empty
                        <option value="" disabled>No Category Found</option>
                        @endforelse
                    </select>
                    @error('unity')
                    <span class="text-red-700">{{$message}}</span>
                    @enderror
                </div>
                </div>
                <button type="submit" class="inline-flex justify-center w-full py-2 px-4 border 
                border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600
                 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 
                 focus:ring-indigo-500">
                  Save
                </button>
            </form>
            @else
            <h3 class="text-2xl font-bold">Edit {{$newName}}</h3>
            <form wire:submit.prevent="update({{$selected_id}})" method="POST">
                @csrf
                <div class="field">
                    <x-jet-label for="size" value="{{ __('Slot Size') }}" />
                    <x-jet-input id="size" type="number" class=""
                      wire:model.defer="size" value="{{$size}}" readonly disabled autocomplete="size" />
                    <x-jet-input-error for="size" />
                </div>
                <div class="py-5 bg-white ">
                  <x-jet-label for="price" value="{{ __('Price/Day') }}" />
                  <x-jet-input id="price" type="number" class="mt-1 w-full"
                    wire:model.defer="price" autocomplete="price" />
                  <x-jet-input-error for="price" class="mt-2" />
                </div>
                <div class="field">
                <label for="item" class="label">Item</label>
                <div class="select">
                    <select name="category" wire:model="category">
                        <option value="">-- category --</option>
                        @foreach ($categories as $item)
                            <option value="{{$item->id}}" >{{$item->name}}</option>
                        @endforeach
                    </select>
                    @error('item')
                    <span class="text-red-700">{{$message}}</span>
                    @enderror
                </div>
                </div>
                <button type="submit" class="inline-flex justify-center w-full py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                  Save
                </button>
            </form>
            @endif
          </div>
      </div>
    </div>
  </div>