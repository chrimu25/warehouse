<x-app-layout title="{{isset($wh)?'Edit '.$wh->name:'Add New Warehouse'}}">
    <section class="is-title-bar">
        <div class="flex flex-col md:flex-row items-center justify-between space-y-1 md:space-y-0">
          <ul>
            <li>{{Auth::user()->role}}</li>
            @isset($wh)
                <li>Warehouses</li>
                <li>{{$wh->code}}</li>
            @else
              <li>Insert New Warehouses</li>
            @endisset
          </ul>
        </div>
    </section>
    <div class="bg-gray-100">
        <div class="min-h-screen sm:pt-0">
            <form action="{{ isset($wh)?route('admin.warehouses.update',$wh->id):route('admin.warehouses.store') }}" method="POST"
            enctype="multipart/form-data">
                @csrf
                @isset($wh)
                    @method('PUT')
                @endisset
                <div class="shadow overflow-hidden w-full sm:rounded-md">
                 <div class="mx-6 my-2 rounded">
                  <div class=" md:flex justify-between bg-white">

                    <div class="px-6 bg-white w-full sm:py-2">
                        <x-jet-label for="name" value="{{ __('Warehouse Name') }}" />
                        <x-jet-input id="name" value="{{isset($wh)?$wh->name:old('name')}}" type="text" class="mt-1 block w-full"
                          name="name" autocomplete="name" />
                        <x-jet-input-error for="name" class="mt-2" />
                    </div>
                    <div class="px-6 bg-white w-full sm:py-2">
                        <x-jet-label for="phone" value="{{ __('Phone Number') }}" />
                        <x-jet-input id="phone" value="{{isset($wh)?$wh->phone:old('phone')}}" type="tel" class="mt-1 block w-full"
                          name="phone" autocomplete="phone" />
                        <x-jet-input-error for="phone" class="mt-2" />
                    </div>
                    <div class="px-6 bg-white w-full sm:py-2">
                        <x-jet-label for="email" value="{{ __('Email Address') }}" />
                        <x-jet-input id="email" value="{{isset($wh)?$wh->email:old('email')}}" type="email" class="mt-1 block w-full"
                          name="email" autocomplete="email" />
                        <x-jet-input-error for="email" class="mt-2" />
                    </div>
                  </div>
                    <div class="my-2 md:flex justfy-between">
                    <div class="px-6 bg-white w-full sm:py-2">
                        <x-jet-label for="category" value="{{ __('Product Category') }}" />
                        <select id="category" name="category[]" multiple class="mt-1 block w-full sm:text-sm
                        py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none">
                          <option disabled>Select Product Category</option>
                          @foreach ($categories as $item)
                            <option value="{{$item->id}}" {{old('category')==$item->id?'selected':''}}
                              @isset($wh){{$wh->category_id==$item->id?'selected':''}}@endisset>
                              {{$item->name}}</option>
                          @endforeach
                        </select>
                        <x-jet-input-error for="category" class="mt-2" />
                    </div>
                    <div class="px-6 bg-white w-full sm:py-2">
                        <x-jet-label for="type" value="{{ __('Warehouse Type') }}" />
                        <select id="type" name="type" class="mt-1 block w-full sm:text-sm
                        py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none">
                          <option>Select Warehouse Type</option>
                            <option value="Single" {{old('type')=='Single'?'selected':''}}
                            @isset($wh){{$wh->type=="Single"?'selected':''}} @endisset>Single Item</option>
                            <option value="Multiple" {{old('type')=='Multiple'?'selected':''}}
                            @isset($wh){{$wh->type=="Multiple"?'selected':''}} @endisset>Multiple Items</option>
                        </select>
                        <x-jet-input-error for="type" class="mt-2" />

                      </div>
                    </div>
                    <div class="my-2">
                    <div class="px-6 py-2 bg-white space-y-2 sm:py-2">
                        <x-jet-label for="owner" value="{{ __('Warehouse Owner if any') }}" />
                        <x-jet-input id="owner" type="text" value="{{isset($wh)?$wh->owner:old('owner')}}" class="mt-1 block w-full"
                          name="owner" autocomplete="owner" />
                        <x-jet-input-error for="owner" class="mt-2" />
                    </div>
                    <div class=" md:flex justify-between bg-white">
                    <div class="px-6 py-2 bg-white w-full space-y-2 sm:py-2">
                        <x-jet-label for="fork_lifter" value="{{ __('Fork-Lifters') }}" />
                        <x-jet-input id="fork_lifter" type="number" class="mt-1 block w-full"
                          name="fork_lifter" value="{{isset($wh)?$wh->fork_lifter:old('fork_lifter')}}" autocomplete="fork_lifter" />
                        <x-jet-input-error for="fork_lifter" class="mt-2" />
                    </div>
                    <div class="px-6 py-2 bg-white w-full space-y-2 sm:py-2">
                        <x-jet-label for="slots" value="{{ __('Number of Slots') }}" />
                        <x-jet-input id="slots" type="number" class="mt-1 block w-full"
                          name="slots" value="{{isset($wh)?$wh->num_of_slots:old('slots')}}" autocomplete="slots" />
                        <x-jet-input-error for="slots" class="mt-2" />
                    </div>
                    </div>
                    </div>
                    @if (!isset($wh))
                    @livewire('admin.locations')
                    @endif
                    <div class="px-6 py-2 bg-white space-y-2 sm:py-2">
                        <div class="flex text-sm text-gray-600">
                            <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                              <span>Upload a file</span>
                              <input id="image" name="image" type="file" class="sr-only">
                            </label>
                        </div>
                        <x-jet-input-error for="image" class="mt-2" />
                    </div>
                   </div>
                    @if (!isset($wh))
                    <div class="border mx-6 my-2 rounded md:flex justfy-between">
                      <div class="px-6 bg-white w-full sm:py-2">
                          <x-jet-label for="mname" value="{{ __('Manager Name') }}" />
                          <x-jet-input id="mname" type="text" class="mt-1 block w-full"
                            name="mname" value="{{old('mname')}}" autocomplete="mname" />
                          <x-jet-input-error for="mname" class="mt-2" />
                      </div>
                      <div class="px-6 bg-white w-full sm:py-2">
                          <x-jet-label for="mphone" value="{{ __('Manager Phone Number') }}" />
                          <x-jet-input id="mphone" type="tel" class="mt-1 block w-full"
                            name="mphone" value="{{old('mphone')}}" autocomplete="mphone" />
                          <x-jet-input-error for="mphone" class="mt-2" />
                      </div>
                      <div class="px-6 bg-white w-full sm:py-2">
                          <x-jet-label for="memail" value="{{ __('Manager Email Address') }}" />
                          <x-jet-input id="memail" value="{{old('memail')}}" type="email" class="mt-1 block w-full"
                            name="memail" autocomplete="memail" />
                          <x-jet-input-error for="memail" class="mt-2" />
                      </div>
                    </div>
                    @endif
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border
                        border-transparent shadow-sm text-sm font-medium rounded-md text-white
                        bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2
                        focus:ring-offset-2 focus:ring-indigo-500">
                          Save
                        </button>
                      </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
