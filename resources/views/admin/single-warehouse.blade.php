<x-app-layout :title="$wh->name">
    <section class="is-title-bar">
        <div class="flex flex-col md:flex-row items-center justify-between space-y-1 md:space-y-0">
          <ul>
            <li>{{Auth::user()->role}}</li>
            <li>Warehouse</li>
            <li>{{$wh->name}}</li>
          </ul>
        </div>
    </section>
    <div class="bg-gray-100">
      <div class="bg-gray-200 min-h-screen flex justify-center items-center px-3 py-4">
          <div class="flex gap-7">
              <div class="bg-white w-full lg:w-1/3 p-10 rounded-lg order-2 lg:order-first">
                <h1 class="text-gray-700 font-bold tracking-wider">Warehouse Details</h1>
                <div class="my-10">
                  <div class="flex justify-between items-center">
                      <div class="flex justify-items-start gap-3 items-stretch">
                          <div class="bg-gray-200 w-14"></div>
                          <div>
                              <h1 class="font-bold text-gray-700">Contact Information</h1>
                              @if($wh->email)<p class="text-sm text-gray-500">Email: 
                                <a href="mailto:{{$wh->email}}">{{$wh->email}}</a></p>@endif
                              @if($wh->phone)<p class="text-sm text-gray-500"> Phone:
                                <a class="mr-2" href="tel:{{$wh->phone}}">{{$wh->phone}}</a></p>@endif
                          </div>
                      </div>
                  </div>
                  <div class="flex justify-between items-center mt-5">
                      <div class="flex justify-items-start gap-3 items-stretch">
                          <div class="bg-gray-200 w-14"></div>
                          <div>
                              <h1 class="font-bold text-gray-700">Owner</h1>
                              <p class="text-sm text-gray-500">{{$wh->owner?$wh->owner:'-----'}}</p>
                          </div>
                      </div>
                  </div>
                  @if($wh->manager)
                  <div class="flex justify-between items-center mt-5">
                    <div class="flex justify-items-start gap-3 items-stretch">
                        <div class="bg-gray-200 w-14"></div>
                        <div>
                            <h1 class="font-bold text-gray-700">Manager</h1>
                            <p class="text-sm text-gray-500">Name: {{$wh->manager->name}}</p>
                            <p class="text-sm text-gray-500">Email: 
                              <a href="mailto:{{$wh->manager->email}}">{{$wh->manager->email}}</a></p>
                            <p class="text-sm text-gray-500"> Phone:
                              <a class="mr-2" href="tel:{{$wh->manager->phone}}">{{$wh->manager->phone}}</a></p>
                        </div>
                    </div>
                  </div>
                  @endif
                </div>
              </div>
              <div class="bg-white w-full lg:w-1/3 p-10 rounded-lg order-2 lg:order-first">
                <h1 class="text-gray-700 font-bold tracking-wider">Additional Info</h1>
                <div class="items-stretch mt-3">
                    <div>
                        <h1 class="font-bold text-gray-700"></h1>
                        <p class="text-sm text-gray-500 mb-2"><strong>Fork Lifters:</strong> {{$wh->fork_lifter}}</p>
                        <p class="text-sm text-gray-500 mb-2"><strong>Max Number of Slots:</strong> {{$wh->num_of_slots}}</p>
                        <p class="text-sm text-gray-500 mb-2"><strong>Province:</strong> {{$wh->province->name}}</p>
                        <p class="text-sm text-gray-500 mb-2"><strong>District:</strong> {{$wh->district->name}}</p>
                        <p class="text-sm text-gray-500 mb-2"><strong>Sector:</strong> {{$wh->sector->name}}</p>
                        <p class="text-sm text-gray-500 mb-2"><strong>Cell:</strong> {{$wh->cell->name}}</p>
                    </div>
                </div>
              </div>
              <div class="w-full lg:w-1/5 order-1 lg:order-last flex flex-col justify-start gap-7">
                  <div class="bg-white p-2 rounded-lg text-center">
                      <img src="https://i.ytimg.com/vi/mtXQ-m2xPEY/maxresdefault.jpg" alt="" class="h-20 w-full object-cover content-center rounded-t-lg"/>
                      <div class="flex justify-center">
                          <img src="{{asset($wh->picture?Storage::url($wh->picture):'images/landing.jpg')}}" alt="" 
                          class="w-20 h-20 rounded-full object-cover content-center -mt-10 border-4 border-white"/>
                      </div>
                      <h1 class="text-center font-bold tracking-wider text-gray-700 mt-4">{{$wh->name}}</h1>
                      <p class="text-gray-500 mt-1 text-center">{{$wh->code}}</p>
                      <br/>
                      <div class="mt-5 flex justify-between mx-10 mb-5">
                          <div class="text-left">
                              <h1 class="text-gray-500">Empty Slots</h1>
                              <p class="text-3xl text-gray-800">{{$wh->EmptySlots->count()}}</p>
                          </div>
                          <div class="text-left">
                              <h1 class="text-gray-500">Occupied</h1>
                              <p class="text-3xl text-gray-800">{{$wh->fullSlots->count()}}</p>
                          </div>
                      </div>
                      <div></div>
                  </div>
                  <div class="bg-white rounded-lg p-6">
                      <h1 class="font-bold tracking-wider text-gray-800">Slots Categories</h1>
                      <ul>
                        @forelse ($wh->categories as $category)
                          <li>{{$category->name}}</li>
                        @empty
                          <li>No Category Yet</li>
                        @endforelse
                      </ul>
                  </div>
              </div>
          </div>
      </div>
    </div>
</x-app-layout>
