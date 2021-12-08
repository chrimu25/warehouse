<div class="md:flex justify-between">
    <div class='my-5 w-full p-3 opacity-60'>
        <p>From</p>
            <div class="flex justify-between">

                <div class="my-2 w-full">
                    <p>Product</p>
                    <input type="text" class="shadow appearance-none border rounded w-full 
                    py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    readonly value="{{$item->item->name}}"> 
                </div> 
                <div class="my-2 w-full ml-2">
                    <p>Category</p>
                    <input type="text" class="shadow appearance-none border rounded w-full 
                    py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    readonly value="{{$item->category->name}}"> 
                </div> 
            </div>
            <div class="flex justify-between">
                <div class="my-2 w-full mr-2">
                    <p>Warehouse</p>
                    <input type="text" class="shadow appearance-none border rounded w-full 
                    py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    readonly value="{{$item->warehouse->name}}"> 
                </div>
                 <div class="my-2 w-full">
                    <p>Slot</p>
                    <input type="text" class="shadow appearance-none border rounded w-full 
                    py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    readonly value="{{$item->slot->name}}"> 
                </div> 
            </div>
            <div class="flex justify-between">
                <div class="my-2 w-full">
                    <p>Quantity</p>
                    <input type="text" value="{{$item->quantity.$item->unity->name}}" 
                    class="shadow appearance-none border rounded w-full 
                    py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"> 
                </div> 
            </div>
            <div class="my-1 w-full">
                <p>Number of days</p>
                <input type="text" class="shadow appearance-none border rounded w-full py-2 
                px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                readonly value="{{ \Carbon\Carbon::createFromFormat('Y-m-d', date('Y-m-d'))->diffInDays( \Carbon\Carbon::createFromFormat('Y-m-d', $item->created_at->format('Y-m-d')))}}"> 
            </div> 
    </div>
    <div class='my-5 w-full p-3 bg-white shadow-lg rounded mr-3'>
        <p>To</p>
        <form class='' method="POST" wire:submit.prevent="store">
            @csrf
            <div class="flex justify-between">
                <div class='my-2 w-full mr-2'>
                    <p>Location<span class="text-red-500">*</span></p>
                    <select class="shadow appearance-none border rounded w-full py-2 px-3 
                    text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    name="location" wire:model.lazy="location">
                        <option value="" selected>-- Select Location --</option>
                        @foreach ($locations as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                    <x-jet-input-error for="location" class="mt-2" />
                </div>
                @if ($location)
                <div class='my-2 w-full'>
                    <p>Warehouse</p>
                    <select class="shadow appearance-none border rounded w-full py-2 px-3 
                    text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    name="warehouse" wire:model.lazy="warehouse">
                        <option value="" selected>-- Select Warehouse --</option>
                        @foreach ($warehouses as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                    <x-jet-input-error for="warehouse" class="mt-2" />
                </div>
                @endif
            </div>
            
            <div class='my-4 w-full'>
                <p>Slot</p>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700
                leading-tight focus:outline-none focus:shadow-outline" 
                name="slot" wire:model.lazy="slot">
                <option value="" selected>-- Select Slot --</option>
                    @if ($warehouse)
                        @forelse ($slots as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                        @empty
                        <option value="" selected disabled>No Slots Found   </option>
                        @endforelse
                    @endif
                </select>
                <x-jet-input-error for="slot" class="mt-2" />
            </div>
            <input type="hidden" wire:model="oldWarehouse">
            <div class="flex justify-between">
                <div class=" w-full mr-2">
                    <p>Starting Date</p>
                    <input type="date" class="shadow appearance-none border rounded w-full py-2 px-3 
                    text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    wire:model="startingDate">
                    <x-jet-input-error for="startingDate" class="mt-2" />
                </div>
                <div class=" w-full">
                    <p>Until</p>
                    <input type="date" class="shadow appearance-none border rounded w-full py-2 px-3 
                    text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    wire:model="enddate">
                    <x-jet-input-error for="enddate" class="mt-2" />
                </div>
            </div>
            <div class="my-2 w-full">
                <p>Quantity</p>
                <input type="number" class="shadow appearance-none border rounded w-full py-2 px-3 
                text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                wire:model.lazy="quantity">
                <input type="hidden" name="oldQuantity" readonly  wire:model.lazy="oldQuantity">
                <x-jet-input-error for="quantity" class="mt-2" />
            </div>
            <button class="bg-blue-400 hover:bg-blue-600 text-white font-bold py-2 px-4 mt-2 rounded
            focus:outline-none focus:shadow-outline w-full" type="submit" 
            wire:target="store"
            wire:loading.attr="disabled">
               <span wire:loading.remove wire:target="store">Submit Transfer</span>
               <span wire:loading wire:target="store">Processing</span>
           </button>
         
        </form>
</div>
