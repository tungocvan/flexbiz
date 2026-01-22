<div class="space-y-6">
    {{-- Header & Filters --}}
    <div class="flex flex-col sm:flex-row justify-between gap-4 items-center bg-white p-4 rounded-lg shadow-sm border border-gray-200">
        <h2 class="text-xl font-bold text-gray-800">Quản lý Đối Tác & Hoa Hồng</h2>
        
        <div class="flex gap-3">
            <select wire:model.live="statusFilter" class="border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="all">Tất cả trạng thái</option>
                <option value="pending">Chờ duyệt (Pending)</option>
                <option value="approved">Đã duyệt (Approved)</option>
                <option value="rejected">Đã hủy (Rejected)</option>
            </select>
            
            <input type="text" wire:model.live.debounce.300ms="search" 
                   placeholder="Tìm mã đơn hàng..." 
                   class="border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500">
        </div>
    </div>

    {{-- Data Table --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mã Đơn</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Người giới thiệu (Affiliate)</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Giá trị đơn</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hoa hồng</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Hành động</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($commissions as $item)
                    <tr wire:key="comm-{{ $item->id }}" class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
    
                            {{-- CLICK VÀO ĐÂY ĐỂ MỞ MODAL --}}
                            <button wire:click="$dispatch('open-order-modal', { orderId: {{ $item->id }} })" 
                                    class="text-blue-600 hover:text-blue-800 hover:underline flex items-center gap-1 group">
                                {{ $item->order_code }}
                                <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                        
                            <div class="text-xs text-gray-500 font-normal mt-1">{{ $item->created_at->format('d/m/Y H:i') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-8 w-8">
                                    <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($item->affiliate->name ?? 'N/A') }}" alt="">
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900">{{ $item->affiliate->name ?? 'Unknown' }}</div>
                                    <div class="text-xs text-gray-500">{{ $item->affiliate->email ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ number_format($item->total) }}đ
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-blue-600">
                            {{ number_format($item->commission_amount) }}đ
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($item->commission_status === 'approved')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Đã duyệt
                                </span>
                            @elseif($item->commission_status === 'rejected')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Từ chối
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Chờ duyệt
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            @if($item->commission_status === 'pending')
                                <button wire:click="approve({{ $item->id }})" 
                                        wire:confirm="Bạn có chắc chắn muốn DUYỆT hoa hồng này?"
                                        class="text-green-600 hover:text-green-900 mr-3 font-bold">Duyệt</button>
                                
                                <button wire:click="reject({{ $item->id }})" 
                                        wire:confirm="Bạn có chắc chắn muốn TỪ CHỐI hoa hồng này?"
                                        class="text-red-600 hover:text-red-900">Từ chối</button>
                            @else
                                <span class="text-gray-400 text-xs italic">Đã xử lý</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                            Chưa có dữ liệu hoa hồng nào.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $commissions->links() }}
    </div>
    <div>
        @livewire('admin.orders.order-detail-modal')
    </div>
</div>