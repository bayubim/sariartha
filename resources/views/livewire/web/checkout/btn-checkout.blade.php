<div>
    @if($address)
        <button wire:click="storeCheckout" class="btn btn-orange-2 rounded border-0 shadow-sm w-100">
            {{ $loading ? 'Processing' : 'Process to Payment' }}
        </button>
    @endif
</div>