<x-app-layout title="{{$item->item->name}} CheckOut">
    <section class="is-title-bar">
        <div class="flex flex-col md:flex-row items-center justify-between space-y-1 md:space-y-0">
          <ul>
            <li>{{$item->item->name}} CheckOut</li>
          </ul>
        </div>
    </section>
    <div class="bg-gray-100">
        <div class="min-h-screen sm:pt-0 bg-white rounded">
            {{-- @livewire('clients.activity-in', ['item' => $item], key($item->id)) --}}
            <form class="mx-8 py-3" method="POST" 
            action="{{ route('client.activity.checkout', $item->id) }}">
              @csrf
              <div class='flex justify-between my-3 '>
                  <div class="w-full">
                      <p>Products</p>
                      <input type="text" value="{{$item->item->name}}" class="shadow appearance-none border rounded w-full py-2 px-3 
                      text-gray-700 leading-tight focus:outline-none focus:shadow-outline" disabled>
                      <input type="hidden" name="product">
                  </div>
                  <div class="w-full ml-3">
                      <p>Warehouse</p>
                      <input type="text" value="{{$item->warehouse->name}}" class="shadow appearance-none border rounded w-full py-2 px-3 
                      text-gray-700 leading-tight focus:outline-none focus:shadow-outline" disabled>
                      <input type="hidden" name="wh">
                  </div>
              </div>
              <div class='flex justify-between my-3 '>
                  <div class="w-full">
                      <p>From</p>
                      <input type="text" value="{{$item->until->format('Y-m-d')}}" class="shadow appearance-none border rounded w-full py-2 px-3 
                      text-gray-700 leading-tight focus:outline-none focus:shadow-outline" disabled>
                  </div>
                  <div class="w-full ml-3">
                      <p>Until</p>
                      <input type="text" value="{{$item->created_at->format('Y-m-d')}}" class="shadow appearance-none border rounded w-full py-2 px-3 
                      text-gray-700 leading-tight focus:outline-none focus:shadow-outline" disabled>
                  </div>
              </div>
              <div class='my-5'>
                <div class='flex justify-between'>
                  <div class='w-full'>
                      <p>Previous Quantity</p>
                      <input type="text" value="{{$item->quantity}}" class="shadow appearance-none 
                      border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none 
                      focus:shadow-outline" readonly name="oldQuantity">
                    </div>
                  <div class="mx-3 w-full">
                      <p>Checkout Quantity <span class="text-red-700">*</span></p>
                      <input type="number" class="shadow appearance-none border-gray-500 rounded w-full 
                      py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                      name="newQuantity" value="{{old('newQuantity')}}"autofocus min="1">
                      <x-jet-input-error for="newQuantity" class="mt-2" />
                  </div>
                  <div class='w-1/2'>
                  <p>Units</p>
                   <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" >
                      <option>Kilograms</option>
                      <option>litters</option>
                      <option>boxes</option>
                  </select>
                  </div>
                </div>
              </div>
              <button class="bg-blue-400 hover:bg-blue-600 text-white font-bold py-2 px-4 
              rounded focus:outline-none focus:shadow-outline" type="submit">
                  Submit Request
              </button>
          </form>
        </div>
    </div>
</x-app-layout>
