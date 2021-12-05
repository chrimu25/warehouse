<form wire:submit.prevent="store" method="POST" class="px-7">
{{-- <form action="{{ route('manager.products.store') }}" method="POST" class="px-7"> --}}
    @csrf
    <div class="field">
        <div class="field-body">
            @if (session()->has('wh-warning'))
            <div role="alert">
                <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                  Attention Needed
                </div>
                <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                  <p>{{session()->get('wh-warning')}}</p>
                </div>
            </div>
            @endif
            @if (Auth::user()->warehouse->slots->count() <1)
            <div class="flex flex-col p-8 bg-white shadow-md hover:shodow-lg rounded-2xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-16 h-16 rounded-2xl p-3 border border-blue-100 text-blue-400 bg-blue-50" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="flex flex-col ml-3">
                            <div class="font-medium leading-none">Attention</div>
                            <p class="text-sm text-gray-600 leading-none mt-1">Warehouse you're managing has no Slot! Try to add Onebefore you start inserting product in it!
                            </p>
                        </div>
                    </div>
                    <button  class="flex-no-shrink bg-red-500 px-5 ml-4 py-2 text-sm shadow-sm hover:shadow-lg font-medium tracking-wider border-2 border-red-500 text-white rounded-full">Delete</button>
                </div>
            </div>
            @else    
            <div class="flex justify-between w-full">
                <div class="w-2/3">
                    <label class="label">Owner</label>
                    <div class="control">
                        <div class="select">
                            <select name="owner" wire:model.lazy="owner">
                                <option value="">-- Select Item Owner --</option>
                                @foreach ($users as $item)
                                    <option value="{{$item->id}}" {{$item->id==old('owner')?'selected':''}} 
                                    >{{$item->name}}</option>
                                @endforeach
                            </select>
                            @error('owner')
                            <span class="text-red-700">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="w-1/3 flex justify-end">
                    <a href="#!" class="bg-gray-600 text-white mt-7 px-4 py-2 rounded" id="open-btn">
                        <i class="mdi mdi-plus"></i> Create User
                    </a>
                </div>
            </div>
            <table>
                <tbody>
                    @foreach($items as $index=>$item)
                    <tr>
                        <td>
                            <label for="item" class="label">Product</label>
                            <div class="select">
                            <select name="items[{{$index}}][item]" 
                            wire:model.lazy="items.{{$index}}.item">
                                <option value="">-- Product --</option>
                                @foreach ($products as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                            @error('items.'.$index.'.item')
                            <span class="text-red-700">{{$message}}</span>
                            @enderror
                            </div>
                        </td>
                        <td>
                            <label for="quantity" class="label">Slots</label>
                            <div class="select">
                            <select name="items[{{$index}}][slot]"  
                            wire:model.lazy="items.{{$index}}.slot">
                                <option value="">slot</option> 
                                @foreach ($slots as $item)
                                    <option value="{{$item->id}}">
                                        {{$item->name}},  
                                        {{$item->unity->name}}, 
                                        {{$item->remaining}}
                                    </option>
                                @endforeach
                            </select>
                            @error('items.'.$index.'.slot')
                            <span class="text-red-700">{{$message}}</span>
                            @enderror
                            </div>
                        </td>
                        <td>
                            <label for="quantity" class="label">Quantity</label>
                            <input class="input @error('items.'.$index.'.quantity') border-red-600 @enderror" type="number" 
                            name="items[{{$index}}][quantity]" 
                            wire:model.lazy="items.{{$index}}.quantity">
                            @error('items.'.$index.'.quantity')
                            <span class="text-red-700">{{$message}}</span>
                            @enderror
                            <input type="hidden" value="{{$quantity1}}" name="items[{{$index}}][maxQuantity]" 
                            wire:model.lazy="items.{{$index}}.maxQuantity">
                        </td>
                        <td>
                            <label for="duration" class="label">Duration</label>
                            <input class="input @error('items.'.$index.'.duration') border-red-600 @enderror" 
                            type="date" 
                            name="items[{{$index}}][duration]" 
                            wire:model.lazy="items.{{$index}}.duration">
                            @error('items.'.$index.'.duration')
                            <span class="text-red-700">{{$message}}</span>
                            @enderror
                        </td>
                        <td class="">
                            <div class="flex justify-between mt-7">
                                <button class="rounded bg-green-400 p-1 px-2" wire:click.prevent="addNewRow">
                                    <i class="mdi mdi-plus"></i>
                                </button>
                                <button class="rounded bg-red-400 p-1 px-2" wire:click.prevent="removeRow({{$index}})">
                                    <i class="mdi mdi-minus"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="5" class="flex justify-end">
                        <button class="button" type="submit">Insert</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            @endif
        </div>
        </div>
</form>