<x-app-layout title="Edit {{$user->name}}">
    <section class="is-title-bar">
        <div class="flex flex-col md:flex-row items-center justify-between space-y-1 md:space-y-0">
          <ul>
            <li>{{Auth::user()->role}}</li>
            <li>Managers</li>
            <li>{{$user->name}}</li>
          </ul>
        </div>
    </section>
    <div class="bg-gray-100">
        <div class="min-h-screen sm:pt-0 px-5">
          <form action="{{ route('admin.managers.update',$user->id) }}" method="POST" class="px-7">
            @csrf
            @method('PUT')
            <div class="field">
                <div class="field-body">
                  <div class="field">
                    <div class="control icons-left">
                      <input class="input @error('name') border-red-600 @enderror" type="text" name="name" 
                      value="{{old('name',$user->name)}}">
                      <span class="icon left"><i class="mdi mdi-account"></i></span>
                      @error('name')
                      <span class="text-red-700">{{$message}}</span>
                      @enderror
                    </div>
                  </div>
                  <div class="field grouped">
                    <div class="control icons-left">
                      <input class="input @error('email') border-red-600 @enderror" type="email" 
                      name="email" value="{{old('email',$user->email)}}">
                      <span class="icon left"><i class="mdi mdi-mail"></i></span>
                      @error('email')
                      <span class="text-red-700">{{$message}}</span>
                      @enderror
                    </div>
                    <div class="control icons-left">
                      <input class="input @error('phone') border-red-600 @enderror" type="tel" 
                      name="phone" value="{{old('phone',$user->phone)}}">
                      <span class="icon left"><i class="mdi mdi-phone"></i></span>
                      @error('phone')
                      <span class="text-red-700">{{$message}}</span>
                      @enderror
                    </div>
                  </div>
                  <div class="field">
                    <label class="label">Warehouse</label>
                    <div class="control">
                      <div class="select">
                        <select name="warehouse">
                          <option value="">Assign Warehouse</option>
                          @foreach ($warehouses as $item)
                              <option value="{{$item->id}}" @if($user->warehouse) {{$item->id==$user->warehouse->id?'selected':''}}
                                 @endif>{{$item->name}}</option>
                          @endforeach
                        </select>
                        @error('warehouse')
                        <span class="text-red-700">{{$message}}</span>
                        @enderror
                      </div>
                    </div>
                  </div>
                  <div class="field">
                    <label class="label">Active</label>
                    <div class="field-body">
                      <div class="field">
                        <label class="switch">
                          <input type="checkbox" name="status" {{$user->status?'checked':''}} value="{{$user->status?'true':'false'}}">
                          <span class="check"></span>
                          <span class="control-label">{{$user->status?'Block':'Unblock'}}</span>
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="field">
                    <div class="control">
                      <button type="submit" class="button green">
                        Update Info
                      </button>
                    </div>
                  </div>
                </div>
              </div>
          </form>
        </div>
    </div>
</x-app-layout>
