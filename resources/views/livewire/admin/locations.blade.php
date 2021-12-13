<div class=" md:flex justify-between bg-white">
    <div class="px-6 w-full sm:py-2">
        <x-jet-label for="province" value="{{ __('Province') }}" />
        <select id="province" name="province" wire:model.debounce.500="province" class="mt-1 block w-full sm:text-sm
        py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none">
          <option>Select Province</option>
          @foreach ($provinces as $item)
            <option value="{{$item->id}}" {{old('province')==$item->id?'selected':''}}
                 >{{$item->name}}</option>
          @endforeach
        </select>
        <x-jet-input-error for="province" class="mt-2" />
    </div>
    <div class="px-6 w-full sm:py-2">
        <x-jet-label for="district" value="{{ __('District') }}" />
        <select id="district" name="district" wire:model.debounce.500="district" class="mt-1 block w-full sm:text-sm
        py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none">
          <option>Select District</option>
            @if($province)
            @foreach ($districts as $item)
            <option value="{{$item->id}}" {{old('district')==$item->id?'selected':''}}
                >{{$item->name}}</option>
            @endforeach
            @else
            <option disabled>--Nothing found--</option>
            @endif
        </select>
        <x-jet-input-error for="district" class="mt-2" />
    </div>
    <div class="px-6 w-full sm:py-2">
        <x-jet-label for="sector" value="{{ __('Sector') }}" />
        <select id="sector" name="sector" wire:model.debounce.500="sector" class="mt-1 block w-full sm:text-sm
        py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none">
          <option>Select Sector</option>
            @if($district)
            @foreach ($sectors as $item)
            <option value="{{$item->id}}" {{old('sector')==$item->id?'selected':''}}
                >{{$item->name}}</option>
            @endforeach
            @else
            <option disabled>--Nothing found--</option>
            @endif
        </select>
        <x-jet-input-error for="sector" class="mt-2" />
    </div>
    <div class="px-6 w-full sm:py-2">
        <x-jet-label for="cell" value="{{ __('Cell') }}" />
        <select id="cell" name="cell" wire:model.debounce.500="cell" class="mt-1 block w-full sm:text-sm
        py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none">
          <option>Select Cell</option>
            @if($sector)
            @foreach ($cells as $item)
            <option value="{{$item->id}}" {{old('cell')==$item->id?'selected':''}}
                >{{$item->name}}</option>
            @endforeach
            @else
            <option disabled>--Nothing found--</option>
            @endif
        </select>
        <x-jet-input-error for="cell" class="mt-2" />
    </div>
  </div>
