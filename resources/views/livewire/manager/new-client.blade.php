<form wire:submit="insert" method="POST">
    @csrf
    <div class="field">
      <div class="field-body">
       <label class="label">Client Name</label>
       <input class="input @error('name') border-red-600 @enderror" 
       type="text" name="name" wire:model="name" value="{{old('name')}}">
       @error('name')
       <span class="text-red-700">{{$message}}</span>
       @enderror
      </div>
      <div class="field-body">
       <label class="label">Email</label>
       <input class="input @error('email') border-red-600 @enderror" 
       type="email" name="email" wire:model="email" value="{{old('email')}}">
       @error('email')
       <span class="text-red-700">{{$message}}</span>
       @enderror
      </div>

      <div class="field-body">
       <label class="label">Phone</label>
       <input class="input @error('phone') border-red-600 @enderror" 
       type="tel" name="phone" wire:model="phone"value="{{old('phone')}}">
       @error('phone')
       <span class="text-red-700">{{$message}}</span>
       @enderror
      </div> 
      <div class="field-body">
       <label class="label">National ID</label>
       <input class="input @error('nid') border-red-600 @enderror" 
       type="text" name="nid" wire:model="nid" value="{{old('nid')}}">
       @error('nid')
       <span class="text-red-700">{{$message}}</span>
       @enderror
      </div>         </div>
    <!--footer-->
    <div class="p-3  mt-2 text-right space-x-4 md:block">
        <a href="#!" class="mb-2 md:mb-0 bg-red-400 px-5 py-2 text-sm shadow-sm font-medium tracking-wider 
        border text-white rounded-full hover:shadow-lg hover:bg-red-300" id="close-btn">
            Cancel
        </a>
        <button class="mb-2 md:mb-0 bg-blue-500 border border-blue-500 px-5 py-2 text-sm 
        shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg 
        hover:bg-blue-600" type="submit">Insert</button>
    </div>
</form>