<div class="w-full pt-4">
    <div x-show="openTab === 1">
      <div class="min-w-full px-2 rounded shadow-md">
        <x-table>
            <x-table.header>
                <p class="card-header-title">
                    <span class="icon"><i class="mdi mdi-label"></i></span>
                    Incoming Requests ({{$requests->count()}})
                </p>
            </x-table.header>
            <x-slot name="heading">
                <x-table.heading>#</x-table.heading>
                <x-table.heading>Item</x-table.heading>
                <x-table.heading>Date</x-table.heading>
                <x-table.heading>Until</x-table.heading>
                <x-table.heading>Status</x-table.heading>
                <x-table.heading>Options</x-table.heading>
            </x-slot>
            @forelse ($requests as $item)
            <x-table.row>
                <x-table.cell data-label="#"> {{$loop->iteration}}</x-table.cell>
                <x-table.cell data-label="Item">
                    <div class="text-sm text-gray-900">{{$item->item?$item->item->name:''}}</div>
                    <div class="flex items-center sm:flex-column sm:items-start">
                        <div class="text-sm text-gray-500">
                            <span class="text-bold">{{$item->quantity}}{{$item->unity?$item->unity->name:''}}</span>
                        </div>
                      </div>
                </x-table.cell>
                <x-table.cell data-label="Date"> {{$item->created_at->format('Y-d-m')}} </x-table.cell>
                <x-table.cell data-label="Until">
                  <span @if (\Carbon\Carbon::now()->gte($item->until)) class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                    bg-yellow-100 text-yellow-800"@endif> 
                    {{$item->until->format('Y-d-m')}} 
                  </span>
                </x-table.cell>
                <x-table.cell data-label="Status">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                    @if($item->status=="Approved") 
                    bg-green-100 text-green-800 @elseif($item->status=="Pending") 
                    bg-yellow-100 text-yellow-800 
                    @else bg-red-100 text-red-800 @endif">
                        {{$item->status}}
                      </span>
                </x-table.cell>
                <x-table.cell data-label="Options" class="flex justify-between"> 
                  @if ($item->status=="Pending")
                    <button class="block mr-1 px-4 py-1 w-full text-sm capitalize text-gray-700 bg-green-300
                        rounded hover:bg-green-200 hover:text-white" wire:click="ApproveRequest({{$item->id}})" 
                        wire:loading.attr="disabled">Approve
                    </button>
                    <button class="block px-4 py-1 w-full text-sm capitalize text-gray-700 bg-yellow-300
                        rounded hover:bg-yellow-200 hover:text-white" wire:click="DenyRequest({{$item->id}})" 
                        wire:loading.attr="disabled">Deny
                    </button>
                    @elseif ($item->status=="Approved")
                    <button class="inline-flex justify-center w-full rounded-md border 
                    border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 
                    hover:bg-gray-50" wire:click="moveOut({{$item->id}})" wire:loading.attr="disabled">
                      <span wire:loading.remove>Move Out</span>
                      <span wire:loading wire:target="moveOut">Processing</span>
                    </button>
                  @endif
                </x-table.cell>
            </x-table.row>
            @empty
            <x-table.empty-div>7</x-table.empty-div>
            @endforelse
        </x-table>
         
    </div>
    </div>
    <div x-show="openTab === 2">
      <div class="min-w-full px-2 rounded shadow-md">
        <x-table>
            <x-table.header>
                <p class="card-header-title">
                    <span class="icon"><i class="mdi mdi-label"></i></span>
                    Checkins ({{$checkins->count()}})
                </p>
            </x-table.header>
            <x-slot name="heading">
                <x-table.heading>#</x-table.heading>
                <x-table.heading>Item</x-table.heading>
                <x-table.heading>Date</x-table.heading>
                <x-table.heading>Status</x-table.heading>
                <x-table.heading>Options</x-table.heading>
            </x-slot>
            @forelse ($checkins as $item)
            <x-table.row>
                <x-table.cell data-label="#"> {{$loop->iteration}}</x-table.cell>
                <x-table.cell data-label="Item">
                    <div class="text-sm text-gray-900">{{$item->product->item?$item->product->item->name:''}}</div>
                    <div class="flex items-center sm:flex-column sm:items-start">
                        <div class="text-sm text-gray-500">
                            <span class="text-bold">{{$item->quantity}}{{$item->product->unity?$item->product->unity->name:''}}</span>
                        </div>
                      </div>
                </x-table.cell>
                <x-table.cell data-label="Date"> {{$item->created_at->format('Y-d-m')}}
                </span>
                </x-table.cell>
                <x-table.cell data-label="Status">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                     @if($item->status=="Approved") 
                     bg-green-100 text-green-800 @elseif($item->status=="Pending") 
                     bg-yellow-100 text-yellow-800 
                     @else bg-red-100 text-red-800 @endif">
                        {{$item->status}}
                      </span>
                </x-table.cell>
                <x-table.cell data-label="Options" class="flex justify-between"> 
                    @if ($item->status=="Pending")
                    <button class="block px-4 mr-1 py-1 w-full text-sm capitalize text-gray-700 bg-red-300
                      rounded hover:bg-red-200 hover:text-white" wire:click="DeleteCheckin({{$item->id}})" 
                      wire:loading.attr="disabled">Delete
                    </button>
                    <button class="block mr-1 px-4 py-1 w-full text-sm capitalize text-gray-700 bg-green-300
                        rounded hover:bg-green-200 hover:text-white" wire:click="ApproveCheckin({{$item->id}})" 
                        wire:loading.attr="disabled">
                        <span wire:loading.remove>Approve</span>
                        <span wire:loading wire:target="invoice">Processing</span>
                    </button>
                    <button class="block px-4 py-1 w-full text-sm capitalize text-gray-700 bg-yellow-300
                        rounded hover:bg-yellow-200 hover:text-white" wire:click="DenyCheckin({{$item->id}})" 
                        wire:loading.attr="disabled">
                        <span wire:loading.remove>Deny</span>
                        <span wire:loading wire:target="invoice">Processing</span>
                    </button>
                    @endif
                </x-table.cell>
            </x-table.row>
            @empty
            <x-table.empty-div>7</x-table.empty-div>
            @endforelse
        </x-table>
         
      </div>
    </div>
    <div x-show="openTab === 3">
      <div class="min-w-full px-2 rounded shadow-md">
        <x-table>
            <x-table.header>
                <p class="card-header-title">
                    <span class="icon"><i class="mdi mdi-label"></i></span>
                    Checkouts ({{$checkouts->count()}})
                </p>
            </x-table.header>
            <x-slot name="heading">
                <x-table.heading>#</x-table.heading>
                <x-table.heading>Item</x-table.heading>
                <x-table.heading>Date</x-table.heading>
                <x-table.heading>Status</x-table.heading>
                <x-table.heading>Options</x-table.heading>
            </x-slot>
            @forelse ($checkouts as $item)
            <x-table.row>
                <x-table.cell data-label="#"> {{$loop->iteration}}</x-table.cell>
                <x-table.cell data-label="Item">
                    <div class="text-sm text-gray-900">{{$item->product->item?$item->product->item->name:''}}</div>
                    <div class="flex items-center sm:flex-column sm:items-start">
                        <div class="text-sm text-gray-500">
                            <span class="text-bold">{{$item->quantity}}{{$item->product->unity?$item->product->unity->name:''}}</span>
                        </div>
                      </div>
                </x-table.cell>
                <x-table.cell data-label="Date"> {{$item->created_at->format('Y-d-m')}}
                </span>
                </x-table.cell>
                <x-table.cell data-label="Status">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                     @if($item->status=="Approved") 
                     bg-green-100 text-green-800 @elseif($item->status=="Pending") 
                     bg-yellow-100 text-yellow-800 
                     @else bg-red-100 text-red-800 @endif">
                        {{$item->status}}
                      </span>
                </x-table.cell>
                <x-table.cell data-label="Options" class="flex justify-between"> 
                    @if ($item->status=="Pending")
                    <button class="block px-4 mr-1 py-1 w-full text-sm capitalize text-gray-700 bg-red-300
                      rounded hover:bg-red-200 hover:text-white" wire:click="deleteCheckout({{$item->id}})" 
                      wire:loading.attr="disabled">Delete
                    </button>
                    <button class="block mr-1 px-4 py-1 w-full text-sm capitalize text-gray-700 bg-green-300
                        rounded hover:bg-green-200 hover:text-white" wire:click="ApproveCheckout({{$item->id}})" 
                        wire:loading.attr="disabled">
                        <span wire:loading.remove>Approve</span>
                        <span wire:loading wire:target="invoice">Processing</span>
                    </button>
                    <button class="block px-4 py-1 w-full text-sm capitalize text-gray-700 bg-yellow-300
                        rounded hover:bg-yellow-200 hover:text-white" wire:click="DenyCheckout({{$item->id}})" 
                        wire:loading.attr="disabled">
                        <span wire:loading.remove>Deny</span>
                        <span wire:loading wire:target="invoice">Processing</span>
                    </button>
                    @endif
                </x-table.cell>
            </x-table.row>
            @empty
            <x-table.empty-div>7</x-table.empty-div>
            @endforelse
        </x-table>
         
      </div>
    </div>
    <div x-show="openTab === 4">
      <div class="min-w-full px-2 rounded shadow-md">
        <x-table>
            <x-table.header>
                <p class="card-header-title">
                    <span class="icon"><i class="mdi mdi-label"></i></span>
                    Incoming Transfers ({{$incoming->count()}})
                </p>
            </x-table.header>
            <x-slot name="heading">
                <x-table.heading>#</x-table.heading>
                <x-table.heading>Item</x-table.heading>
                <x-table.heading>From</x-table.heading>
                <x-table.heading>To</x-table.heading>
                <x-table.heading>Status</x-table.heading>
                <x-table.heading>Options</x-table.heading>
            </x-slot>
            @forelse ($incoming as $item)
            <x-table.row>
                <x-table.cell data-label="#"> {{$loop->iteration}}</x-table.cell>
                <x-table.cell data-label="Item">
                  <div class="flex items-center sm:flex-column sm:items-start">
                    <div class="ml-4">
                        <span>{{$item->product()->exists()?$item->product->item->name:''}}</span>
                        <div class="text-gray-500">
                            <div class="my-1">Quantity:<span class="ml-1">{{$item->quantity}}{{$item->unity()->exists()?$item->unity->name:''}}</span></div> 
                        </div>
                    </div>
                  </div>
                </x-table.cell>
                <x-table.cell data-label="From">
                  <div class="flex items-center sm:flex-column sm:items-start">
                    <div class="ml-4">
                        <span>{{$item->fromWarehouse?$item->fromWarehouse->name:''}}</span>
                        <div class="text-gray-500">
                            <div class="my-1">Province:<span>{{$item->fromWarehouse?$item->fromWarehouse->province->name:''}}</span></div> 
                            <div>District:<span>{{$item->fromWarehouse?$item->fromWarehouse->district->name:''}}</span></div> 
                        </div>
                    </div>
                  </div>
                </x-table.cell>
                <x-table.cell data-label="To">
                  {{$item->slot->exists()?$item->slot->name:''}}
                </x-table.cell>
                <x-table.cell data-label="Status">
                  <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                  @if($item->status=="Approved") 
                  bg-green-100 text-green-800 @elseif($item->status=="Pending") 
                  bg-yellow-100 text-yellow-800 
                  @else bg-red-100 text-red-800 @endif">
                     {{$item->status}}
                  </span>
                </x-table.cell>
                <x-table.cell data-label="Options">
                  @if ($item->status=="Pending")
                  <button class="block mr-1 px-4 py-1 w-full text-sm capitalize text-gray-700 bg-green-300
                      rounded hover:bg-green-200 hover:text-white" wire:click="Approve({{$item->id}})" 
                      wire:loading.attr="disabled">
                      Approve
                  </button>
                  <button class="block px-4 py-1 w-full text-sm capitalize text-gray-700 bg-red-300
                    rounded hover:bg-red-200 hover:text-white" wire:click="Deny({{$item->id}})" 
                    wire:loading.attr="disabled">
                    Deny
                  </button>
                  @endif
                </x-table.cell>
            </x-table.row>
            @empty
            <x-table.empty-div>7</x-table.empty-div>
            @endforelse
        </x-table>
         
    </div>
    </div>
    <div x-show="openTab === 5">
      <div class="min-w-full px-2 rounded shadow-md">
        <x-table>
            <x-table.header>
                <p class="card-header-title">
                    <span class="icon"><i class="mdi mdi-label"></i></span>
                    OitGoing Transfers ({{$outgoing->count()}})
                </p>
            </x-table.header>
            <x-slot name="heading">
                <x-table.heading>#</x-table.heading>
                <x-table.heading>Item</x-table.heading>
                <x-table.heading>Warehouse</x-table.heading>
                <x-table.heading>Status</x-table.heading>
                <x-table.heading>Options</x-table.heading>
            </x-slot>
            @forelse ($outgoing as $item)
            <x-table.row>
                <x-table.cell data-label="#"> {{$loop->iteration}}</x-table.cell>
                <x-table.cell data-label="Item">
                  <div class="flex items-center sm:flex-column sm:items-start">
                    <div class="ml-4">
                        <span>{{$item->product()->exists()?$item->product->item->name:''}}</span>
                        <div class="text-gray-500">
                            <div class="my-1">Quantity:<span class="ml-1">{{$item->quantity}}{{$item->unity()->exists()?$item->unity->name:''}}</span></div> 
                            <div>Until:<span class="ml-1">{{$item->until->format('Y-d-m')}}</span></div> 
                        </div>
                    </div>
                  </div>
                </x-table.cell>
                <x-table.cell data-label="Warehouse">
                  <div class="flex items-center sm:flex-column sm:items-start">
                    <div class="ml-4">
                        <span>{{$item->toWarehouse?$item->toWarehouse->name:''}}</span>
                        <div class="text-gray-500">
                            <div class="my-1">Province:<span>{{$item->toWarehouse?$item->toWarehouse->province->name:''}}</span></div> 
                            <div>District:<span>{{$item->toWarehouse?$item->toWarehouse->district->name:''}}</span></div> 
                        </div>
                    </div>
                  </div>
                </x-table.cell>
                <x-table.cell data-label="Status">
                  <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                   @if($item->approved) 
                   bg-green-100 text-green-800 
                   @else bg-yellow-100 text-yellow-800 @endif">
                      {{$item->approved?'Approved':'Pending'}}
                    </span>
              </x-table.cell>
                <x-table.cell data-label="Options" class="flex justify-between"> 
                    @if($item->approved==0)
                    <button class="block mr-1 px-4 py-1 w-full text-sm capitalize text-gray-700 bg-green-300
                        rounded hover:bg-green-200 hover:text-white" wire:click="ApproveOutgoing({{$item->id}})" 
                        wire:loading.attr="disabled">
                        Approve
                    </button>
                    <button class="block px-4 py-1 w-full text-sm capitalize text-gray-700 bg-red-300
                      rounded hover:bg-red-200 hover:text-white" wire:click="deleteOutgoing({{$item->id}})" 
                      wire:loading.attr="disabled">
                      Delete
                    </button>
                    @endif
                </x-table.cell>
            </x-table.row>
            @empty
            <x-table.empty-div>7</x-table.empty-div>
            @endforelse
        </x-table>
         
    </div>
    </div>
  </div>