<form wire:submit.prevent="submit">
    <h4 class="mb-3">Thông tin thanh toán</h4>

    <div class="form-group">
        <label>Họ tên</label>
        <input type="text" class="form-control" wire:model.defer="customer_name">
        @error('customer_name') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="form-group">
        <label>Số điện thoại</label>
        <input type="text" class="form-control" wire:model.defer="customer_phone">
        @error('customer_phone') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="form-group">
        <label>Email</label>
        <input type="email" class="form-control" wire:model.defer="customer_email">
    </div>

    <div class="form-group">
        <label>Địa chỉ</label>
        <textarea class="form-control" wire:model.defer="customer_address"></textarea>
        @error('customer_address') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="form-group">
        <label>Ghi chú</label>
        <textarea class="form-control" wire:model.defer="note"></textarea>
    </div>

    <button type="submit" class="btn btn-primary btn-block">
        Đặt hàng
    </button>
</form>
