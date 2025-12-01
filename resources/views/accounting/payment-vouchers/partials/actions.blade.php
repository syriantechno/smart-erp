<div class="flex items-center justify-center gap-1">
    {{-- View Payment Voucher (placeholder) --}}
    <x-erp.action-button
        icon="Eye"
        variant="primary"
        :title="__('payment_vouchers.actions.view')"
        :onclick=""viewPaymentVoucher({{ $voucher->id }})""
    />

    {{-- Print Payment Voucher (placeholder) --}}
    <x-erp.action-button
        icon="Printer"
        variant="primary"
        :title="__('payment_vouchers.actions.print')"
        :onclick=""printPaymentVoucher({{ $voucher->id }})""
    />

    {{-- Delete Payment Voucher --}}
    <x-erp.action-button
        icon="Trash2"
        variant="danger"
        :title="__('payment_vouchers.actions.delete')"
        :onclick=""deletePaymentVoucher({{ $voucher->id }}, 'PV-{{ str_pad($voucher->id, 5, '0', STR_PAD_LEFT) }}')""
    />
</div>
