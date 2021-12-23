<x-guest-layout>
    <header
      id="header"
      class="header py-28 text-center md:pt-36 lg:text-left xl:pt-44 xl:pb-32">
      <div class="container px-4 sm:px-8 block md:flex items-center">
        <div class="">
          <h1 class="mb-5 text-4xl text-gray-100">
            The leading <span class="text-blue-400">Warehouses</span> management
            system
          </h1>
          <p class="p-large mb-8 text-gray-300">
            Store your products and crops where they are safely stored and
            managed.
          </p>
          <a class="btn-solid-lg text-white" href="#your-link"
            >Find a warehouse</a
          >
        </div>
        <div class="xl:text-right">
          <img class="inline" src="images/landing2.svg" alt="alternative" />
        </div>
      </div>
      <!-- end of container -->
    </header>

    <div class="pt-12 text-center" id="cateories">
      <div class="container px-4 sm:px-8 xl:px-4">
        <h1 class="text-gray-800 my-2">Categories</h1>
        <p class="text-gray-500 leading-13 lg:max-w-5xl lg:mx-auto">
          Whith stocks in almost every district in the whole country we provide
          stocks for the following categories of product and crops
        </p>
      </div>
    </div>

    <div id="features" class="cards-1">
      <div class="container px-2">
        <div class="card">
          <div class="card-image">
            <img src="images/icons/maize.svg" alt="maize" />
          </div>
          <div class="card-body">
            <h5 class="card-title">Creals, Vegetables and Fruits</h5>
            <p class="mb-2">
              We have slots and enough frizeers for your cropsand or products
            </p>
          </div>
        </div>
        <div class="card">
          <div class="card-image">
            <img src="images/icons/metal.svg" alt="alternative" />
          </div>
          <div class="card-body">
            <h5 class="card-title">Timbers and metals storage</h5>
            <p class="mb-2">
              We are capable of storing large amount of metals and timbers and
              or their finished products
            </p>
          </div>
        </div>
        <div class="card">
          <div class="card-image">
            <img src="images/icons/chemicals.svg" alt="alternative" />
          </div>
          <div class="card-body">
            <h5 class="card-title">Chemicals and Electronic products</h5>
            <p class="mb-2">
              From acids, to mobile,TVs and computer accessories, we have stores
              for them
            </p>
          </div>
        </div>
      </div>
    </div>

    <div id="details" class="pt-12 pb-16 lg:pt-16" id="warehouses">
      <div class="bg-gray-800 py-6 mb-6">
        <div class="container px-4 text-center flex justify-between items-center">
          <h1 class="text-gray-200 text-4xl w-full">Find your favourable stock!</h1>
          <div class='flex justify-between w-full'>
           <div class="w-full mx-1">
              <p class='text-white text-left'>Location</p>
              <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700
              leading-tight focus:outline-none focus:shadow-outline" name="category" wire:model.lazy="category">
                  <option value="" selected>Select Location</option>

                  {{-- @forelse ($categories as $item)
                  <option value="{{$item->id}}">{{$item->name}}</option>
                  @empty
                  <option value="" disabled>---- No categories Found ----</option>
                  @endforelse --}}
              </select>
              <x-jet-input-error for="category" class="mt-2" />
          </div>
           <div class="w-full mx-1">
              <p class='text-white text-left'>Products Category</p>
              <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700
              leading-tight focus:outline-none focus:shadow-outline" name="category" wire:model.lazy="category">
                  <option value="" selected>Select Category</option>

                  {{-- @forelse ($categories as $item)
                  <option value="{{$item->id}}">{{$item->name}}</option>
                  @empty
                  <option value="" disabled>---- No categories Found ----</option>
                  @endforelse --}}
              </select>
              <x-jet-input-error for="category" class="mt-2" />
          </div>

      </div>
        </div>
      </div>
      <div class="warehousesContainer" id="warehouses">
        <div class="container warehouse px-4 sm:px-8 my-8">
          <div class="w-full">
            <h2 class="mb-6">Big Chemical store</h2>
            <p class="mb-4">
              Based on our team's extensive experience in developing
            </p>
            <p class="mb-4 font-bold">
              We store following products
            </p>
            <ul class=''>
              <li>Beans</li>
              <li>Beans</li>
              <li>Beans</li>
            </ul>
            <button class="mt-3 bg-blue-400 hover:opacity-75 text-white font-bold py-2 px-4 rounded" type="submit"
            wire:loading.remove wire:target="insert"
            wire:loading.attr="disabled">
               <a href='/request'>Request</a>
            </button>
          </div>
          <div class="w-full flex justify-centers md:justify-end">
            <img class="inline" src="images/chemImg.svg" alt="alternative" />
          </div>
        </div>

      </div>
    </div>

    <div id="pricing" class="cards-2">
      <div class="container px-4 pb-px sm:px-8">
        <h2 class="mb-2.5 text-white lg:max-w-xl lg:mx-auto">How it works</h2>
        <p class="mb-16 text-white lg:max-w-3xl lg:mx-auto">
          With few steps you can have your goods or crops stored safely
        </p>
        <div class="md:flex justify-around mb-24 items-center">
          <div class="w-full items-center">
            <img src="/images/icons/search.svg" />
            <h4 class="text-white text-left my-2">
              Find your favourable Warehouse.
            </h4>
          </div>
          <div class="w-full">
            <img src="/images/icons/booking.svg" />
            <h4 class="text-white text-left my-2">Book your space or slots.</h4>
          </div>
          <div class="w-full">
            <img src="/images/icons/payment.svg" />
            <h4 class="text-white text-left my-2">
              Pay for Your booked space.
            </h4>
          </div>
          <div class="w-full">
            <img src="/images/icons/transport.svg" />
            <h4 class="text-white text-left my-2">
              Bring you goods to the warehouse.
            </h4>
          </div>
        </div>
      </div>
    </div>
</x-guest-layout>
