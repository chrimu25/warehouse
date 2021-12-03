<div class="min-w-full px-2 rounded shadow-md">
<x-table>
    <x-table.header>
        <p class="card-header-title">
            <span class="icon"><i class="mdi mdi-label"></i></span>
            Warehouses
        </p>
        <select class="block  border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
          <option>4</option>
          <option>6</option>
          <option>8</option>
          <option>10</option>
        </select>
        <a href="#" class="card-header-icon">
          Search/perpage/export
        </a>
    </x-table.header>
    <x-slot name="heading">
        <x-table.heading>#</x-table.heading>
        <x-table.heading>Name</x-table.heading>
        <x-table.heading>Manager</x-table.heading>
        <x-table.heading>Products</x-table.heading>
        <x-table.heading>Status</x-table.heading>
        <x-table.heading>Options</x-table.heading>
    </x-slot>
    @forelse ($warehouses as $wh)
    <x-table.row>
        <x-table.cell data-label="#"> {{$loop->iteration}}</x-table.cell>
        <x-table.cell data-label="Name">
            <div class="flex items-center sm:flex-column sm:items-start">
                @if($wh->picture)
                <div class="flex-shrink-0 h-10 w-10">
                  <img class="h-10 w-10 rounded-full" src="{{Storage::url($wh->picture)}}" alt="">
                </div>
                @endif
                <div class="ml-4">
                  <div class="text-sm font-medium text-gray-900">
                    <span class="text-bold">{{$wh->code}}</span>, {{$wh->name}}
                  </div>
                  <div class="text-sm text-gray-500">
                    {{$wh->owner?$wh->owner:''}}
                  </div>
                </div>
              </div>
        </x-table.cell>
        <x-table.cell data-label="Manager">
            <div class="text-sm text-gray-900">{{$wh->manager->name}}</div>
            <div class="text-sm text-gray-500 flex sm:flex-column">
                <a href="tel:{{$wh->manager->phone}}" class="mr-1">{{$wh->manager->phone}}</a>
            <a href="mailto:{{$wh->manager->email}}">{{$wh->manager->email}}</a></div>
        </x-table.cell>
        <x-table.cell data-label="Products"> (523) </x-table.cell>
        <x-table.cell data-label="Status">
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
             {{$wh->active?'bg-green-100 text-green-800':'bg-red-100 text-red-800'}}">
                {{$wh->active?'Active':'Inactive'}}
              </span>
        </x-table.cell>
        <x-table.cell data-label="Options" class="flex justify-between">
            <button class="bg-red-300 px-2 py-1" wire:loading.attr="loading" wire:click="delete({{$wh->id}})"
            onclick="confirm('Are you sure about this?') || event.stopImmediatePropagation();">delete</button>
            <a class="bg-green-300 px-2 py-1" href="{{ route('admin.warehouses.edit', $wh->id) }}">Edit</a>
            <a class="bg-gray-300 px-2 py-1" href="{{ route('admin.warehouses.show', $wh->id) }}">View</a>
        </x-table.cell>
    </x-table.row>
    @empty
    <x-table.empty-div>7</x-table.empty-div>
    @endforelse
</x-table>
<x-table.pagination>
{{$warehouses->links()}}
</x-table.pagination>
</div>