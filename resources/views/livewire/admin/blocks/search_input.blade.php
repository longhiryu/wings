<label>{{ __('text.txt_keyword') }}</label>
<input class="form-control table-index-search" type="text" wire:model.debounce.600ms="keyword"
    placeholder="{{ __('text.txt_search') }}">
