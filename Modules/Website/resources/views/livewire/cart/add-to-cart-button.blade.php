<button
    type="button"
    wire:click="addToCart"
    wire:loading.attr="disabled"
    class="btn btn-primary btn-sm"
>
    <span wire:loading.remove>
        Add to cart
    </span>

    <span wire:loading>
        Adding...
    </span>
</button>
