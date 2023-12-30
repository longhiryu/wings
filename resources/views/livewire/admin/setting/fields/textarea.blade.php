<div class="form-group {{ $errors->has($field['name']) ? ' has-error' : '' }}">
    <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
    <textarea class="form-control {{ Arr::get($field, 'class') }}" id="{{ $field['name'] }}" rows="6" cols="50" wire:model="{{ $field['wire'] }}"></textarea>
    @if ($errors->has($field['name']))
        <small class="help-block">{{ $errors->first($field['name']) }}</small>
    @endif
    <span class="text-muted mb-4">{{ isset($field['desc']) ? __($field['desc']) : null }}</span>
</div>
