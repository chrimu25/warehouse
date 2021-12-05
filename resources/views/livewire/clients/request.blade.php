<table>
 <tbody>
    @foreach([0,1,2] as $index)
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
            <label for="quantity" class="label">Quantity</label>
            <input class="input @error('items.'.$index.'.quantity') border-red-600 @enderror" type="number" 
            name="items[{{$index}}][quantity]" 
            wire:model.lazy="items.{{$index}}.quantity">
            @error('items.'.$index.'.quantity')
            <span class="text-red-700">{{$message}}</span>
            @enderror
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
    @endforeach</tbody>   
</table>
