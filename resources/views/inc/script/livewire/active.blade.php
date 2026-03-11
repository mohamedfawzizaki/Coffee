<button wire:click="toggleStatus({{ $id }})" type="button" class="btn btn-sm @if ($active == 0) btn-outline-danger @elseif ($active == 1) btn-outline-success @endif  waves-effect waves-light px-4 py-2 fs-7 text-nowrap">
    @if ($active == 0)
        @lang('Inactive') <i class="mdi mdi-close"></i>
    @elseif ($active == 1)
        @lang('Active') <i class="mdi mdi-check"></i>
    @endif
</button>

{{--  <div class="form-check form-switch">
    <input
        class="form-check-input"
        type="checkbox"
        role="switch"
        id="status_{{ $id }}"
        wire:click="toggleStatus({{ $id }})"
        {{ $active ? 'checked' : '' }}
    >
</div>  --}}
