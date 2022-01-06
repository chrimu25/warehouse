<x-guest-layout>
  <div
  id="header"
  class="py-28 text-center md:pt-36 lg:text-left xl:pt-44 xl:pb-32">
  <div class="container ">
    <form class=" mx-8  border rounded p-2 shadow-lg" method="POST" wire:submit.prevent="insert ">
      <div class='flex justify-between'>
          <div class="w-full">
              <p>Products Category</p>
              <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700
              leading-tight focus:outline-none focus:shadow-outline" name="category" wire:model.lazy="category">
                  <option value="" selected>-- Select Category --</option>

                  {{-- @forelse ($categories as $item)
                  <option value="{{$item->id}}">{{$item->name}}</option>
                  @empty
                  <option value="" disabled>---- No categories Found ----</option>
                  @endforelse --}}
              </select>
              <x-jet-input-error for="category" class="mt-2" />
          </div>
          <div class='w-full ml-3'>
              <p>Item</p>
              <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700
              leading-tight focus:outline-none focus:shadow-outline" name="item" wire:model.lazy="item">
                  <option value="" selected>-- Select Item --</option>
                  {{-- @if($category)
                  @forelse ($products as $item)
                  <option value="{{$item->id}}">{{$item->name}}</option>
                  @empty
                  <option value="" disabled>---- No Items Found ----</option>
                  @endforelse
                  @endif --}}
              </select>
              <x-jet-input-error for="item" class="mt-2" />
            </div>
          </div>
          <div class='my-5'>
              <div class='flex justify-between'>
                  <div class="mr-3 w-1/3">
                      <p>Products Quantity</p>
                      <input type="number" class="shadow appearance-none border rounded w-full
                      py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                      wire:model.lazy="quantity">
                      <x-jet-input-error for="quantity" class="mt-2" />
                  </div>
                  <div class='w-1/3'>
                  <p>Unities</p>
                  <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700
                  leading-tight focus:outline-none focus:shadow-outline"
                      wire:model.lazy="unity">
                      <option value="" selected>-- Item Unity --</option>
                      {{-- @forelse ($unities as $item)
                      <option value="{{$item->id}}">{{$item->name}}</option>
                      @empty
                      <option value="" disabled>---- No Warehouses Found ----</option>
                      @endforelse --}}
                  </select>
                  <x-jet-input-error for="unity" class="mt-2" />
                  </div>
                  <div class="w-1/3 ml-3">
                  <p>Favourable loaction</p>
                  <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700
                  leading-tight focus:outline-none focus:shadow-outline" name="district" wire:model.lazy="district">
                      <option value="" selected>-- Select Location --</option>
                      {{-- @foreach ($districts as $item)
                      <option value="{{$item->id}}">{{$item->name}}</option>
                      @endforeach --}}
                  </select>
                  <x-jet-input-error for="district" class="mt-2" />
              </div>
        </div>
      </div>
      <div class='my-5'>
          <p>Available warehouses</p>
          <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700
          leading-tight focus:outline-none focus:shadow-outline" wire:model="warehouse">
              <option>-- Select Warehouse --</option>
              {{-- @if (!is_null($district))
                  @forelse ($warehouses as $item)
                  <option value="{{$item->id}}">{{$item->name}}</option>
                  @empty
                  <option value="" disabled>---- No Warehouses Found ----</option>
                  @endforelse
              @endif --}}
          </select>
          <x-jet-input-error for="warehouse" class="mt-2" />
      </div>
      <div class=' my-5'>
          <div class="flex justify-between">
              <div class="w-2/3 mr-3">
                  <p>Available Slots</p>
                  <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700
                  leading-tight focus:outline-none focus:shadow-outline" wire:model.lazy="slot">
                      <option>-- Choose Slot --</option>
                      {{-- @if (!is_null($warehouse))
                      @forelse ($slots as $item)
                      <option value="{{$item->id}}">{{__('Slot Size: ').$item->size.__('m2, Price/Day: ').$item->price.__('Rwf')}}</option>
                      @empty
                      <option value="" disabled>---- No Slots Found ----</option>
                      @endforelse
                  @endif --}}
                  </select>
                  <x-jet-input-error for="slot" class="mt-2" />
              </div>
              <div class="w-1/3">
                  <p>Keep Until</p>
                  <input type="date" min="{{date('Y-m-d')}}" class="shadow appearance-none border rounded w-full
                  py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                  wire:model.lazy="until">
                  <x-jet-input-error for="until" class="mt-2" />
              </div>
          </div>
      </div>
      <button class="bg-blue-400 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded
       focus:outline-none focus:shadow-outline" type="submit"
       wire:loading.remove wire:target="insert"
       wire:loading.attr="disabled">
          Submit Request
      </button>
      <div class="bg-white border-blue-400 text-blue-400
                  font-bold py-2 px-4 rounded"
           wire:loading wire:target="insert">
           Processing...
      </div>
  </form>
  </div>
</div>
</x-guest-layout>
