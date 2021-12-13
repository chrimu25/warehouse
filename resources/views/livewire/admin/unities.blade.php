<div class="grid grid-cols-3 gap-4 w-full p-2">
    <div class="col-span-2 bg-white shadow-sm py-2 px-4 rounded ">
      <x-table>
        <x-table.header>
          <p class="card-header-title">
            <span class="icon"><i class="mdi mdi-label"></i></span>
            Unities
          </p>
          <a href="#" class="card-header-icon">
            <span class="icon"><i class="mdi mdi-reload"></i></span>
          </a>
        </x-table.header>
        <x-slot name="heading">
          <x-table.heading>#</x-table.heading>
          <x-table.heading>Name</x-table.heading>
          <x-table.heading>Options</x-table.heading>
        </x-slot>
        @forelse ($unities as $unity)
          <x-table.row>
            <x-table.cell> {{$loop->iteration}}</x-table.cell>
            <x-table.cell> {{$unity->name}}</x-table.cell>
            <x-table.cell class="flex justify-between"> 
                <button class="bg-red-300 px-2 py-1" wire:loading.attr="loading" wire:click="delete({{$unity->id}})" 
                  onclick="confirm('Are you sure about this?') || event.stopImmediatePropagation();">delete</button> 
                <button class="bg-green-300 px-2 py-1" wire:click="edit({{$unity->id}})">Edit</button> 
              </x-table.cell>
          </x-table.row>   
        @empty
          <x-table.empty-div></x-table.empty-div>
        @endforelse
      </x-table>
      <x-table.pagination>
        {{$unities->links()}}
      </x-table.pagination>
    </div>
    <div class="bg-white shadow-sm py-2 px-4 rounded ">
        
          <div class="sm:mt-0">
              <div class="md:mt-0">
                @if (!$open)
                <h3 class="text-2xl font-bold">Create New unity</h3>
                <form wire:submit.prevent="store" method="POST">
                    @csrf
                    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                      <x-jet-label for="name" value="{{ __('Unity Name') }}" />
                      <x-jet-input id="name" type="text" class="mt-1 block w-full"
                       wire:model.defer="name" autocomplete="name" />
                      <x-jet-input-error for="name" class="mt-2" />
                    </div>
                    <button type="submit" class="inline-flex justify-center w-full py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                      Save
                    </button>
                </form>
                @else
                <h3 class="text-2xl font-bold">Edit {{$name}}</h3>
                <form wire:submit.prevent="update({{$selected_id}})" method="POST">
                    @csrf
                    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                      <x-jet-label for="name" value="{{ __('Unity Name') }}" />
                      <x-jet-input id="name" type="text" class="mt-1 block w-full"
                       wire:model.defer="name" value="{{$unity->name}}" autocomplete="name" />
                      <x-jet-input-error for="name" class="mt-2" />
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