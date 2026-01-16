<div class="space-y-6">

    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">Danh sách Đơn hàng</h2>
            <p class="mt-1 text-sm text-gray-500">Quản lý và theo dõi tiến độ xử lý đơn hàng.</p>
        </div>
        </div>

    <div class="border-b border-gray-200">
        <nav class="-mb-px flex space-x-8 overflow-x-auto custom-scrollbar" aria-label="Tabs">
            @foreach([
                'all' => 'Tất cả',
                'pending' => 'Chờ xử lý',
                'processing' => 'Đang xử lý',
                'shipping' => 'Đang giao',
                'completed' => 'Hoàn thành',
                'cancelled' => 'Đã hủy'
            ] as $key => $label)
                <button
                    wire:click="setStatus('{{ $key }}')"
                    class="{{ $status === $key ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium transition-colors">
                    {{ $label }}
                </button>
            @endforeach
        </nav>
    </div>

    <div class="bg-white rounded-xl shadow-sm ring-1 ring-gray-900/5 overflow-hidden">

        <div class="p-4 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4 min-h-[70px]">

            <div class="flex items-center gap-3 w-full sm:w-auto transition-all duration-300">
                @if(count($selected) > 0)
                    <div class="flex items-center animate-fadeIn bg-red-50 px-3 py-2 rounded-lg border border-red-100">
                        <span class="text-sm text-red-700 mr-3 font-medium">Đã chọn: <strong>{{ count($selected) }}</strong></span>
                        <button
                            wire:click="deleteSelected"
                            wire:confirm="CẢNH BÁO: Bạn có chắc chắn muốn XÓA VĨNH VIỄN các đơn hàng đã chọn? Hành động này không thể hoàn tác!"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white text-red-600 text-xs font-bold uppercase tracking-wide rounded border border-red-200 hover:bg-red-600 hover:text-white hover:border-red-600 transition shadow-sm">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            Xóa vĩnh viễn
                        </button>
                        <button wire:click="$set('selected', [])" class="ml-2 text-xs text-gray-400 hover:text-gray-600 underline">Hủy</button>
                    </div>
                @else
                    <div class="relative w-full sm:w-80">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" /></svg>
                        </div>
                        <input wire:model.live.debounce.300ms="search" type="text"
                            class="block w-full rounded-lg border-0 py-2 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                            placeholder="Tìm mã đơn, tên khách, SĐT...">
                    </div>
                @endif
            </div>

            <select wire:model.live="perPage" class="block w-full sm:w-auto rounded-lg border-0 py-2 pl-3 pr-8 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 cursor-pointer bg-gray-50">
                <option value="10">10 dòng</option>
                <option value="25">25 dòng</option>
                <option value="50">50 dòng</option>
            </select>
        </div>

        <div class="overflow-x-auto relative min-h-[300px]">
            <div wire:loading.flex wire:target="setStatus, search, perPage, deleteSelected" class="absolute inset-0 bg-white/60 z-20 items-center justify-center backdrop-blur-[1px]">
                <svg class="animate-spin h-8 w-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
            </div>

            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th scope="col" class="relative px-6 py-3 w-12 text-center">
                            <input type="checkbox" wire:model.live="selectAll" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600 cursor-pointer">
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">Mã đơn hàng</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">Khách hàng</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">Tổng tiền</th>
                        <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wide text-gray-500">Trạng thái</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">Ngày đặt</th>
                        <th class="relative px-6 py-3"><span class="sr-only">Hành động</span></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($orders as $order)
                        <tr class="hover:bg-gray-50/50 transition duration-150 {{ in_array($order->id, $selected) ? 'bg-indigo-50/60' : '' }}">

                            <td class="relative px-6 py-4 w-12 text-center">
                                @if(in_array($order->status, ['pending', 'cancelled']))
                                    <input type="checkbox" value="{{ $order->id }}" wire:model.live="selected" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600 cursor-pointer">
                                @else
                                    <input type="checkbox" disabled class="h-4 w-4 rounded border-gray-200 text-gray-300 bg-gray-100 cursor-not-allowed" title="Không thể xóa đơn hàng đang xử lý">
                                @endif
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="text-indigo-600 font-bold hover:text-indigo-900 font-mono">
                                    #{{ $order->order_code }}
                                </a>
                                <div class="text-xs text-gray-500 mt-0.5">{{ $order->items_count }} sản phẩm</div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">{{ $order->customer_name }}</div>
                                <div class="text-xs text-gray-500">{{ $order->customer_phone }}</div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-bold text-gray-900">{{ number_format($order->total) }} ₫</div>
                                <div class="text-xs text-gray-500">{{ $order->payment_method === 'cod' ? 'COD' : 'CK' }}</div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                {!! $order->status_badge !!}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $order->created_at->format('d/m/Y H:i') }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="text-gray-400 hover:text-indigo-600 transition p-2" title="Xem chi tiết">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500 italic">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                    <span>Không tìm thấy đơn hàng nào.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="bg-gray-50 border-t border-gray-200 px-4 py-3 sm:px-6">
            {{ $orders->links() }}
        </div>
    </div>
</div>
