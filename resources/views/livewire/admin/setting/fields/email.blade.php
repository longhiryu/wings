<div class="form-group {{ $errors->has($field['name']) ? ' has-error' : '' }}">
    <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
    <input type="{{ $field['type'] }}" name="{{ $field['name'] }}" class="form-control {{ Arr::get($field, 'class') }}"
        id="{{ $field['name'] }}" placeholder="{{ $field['label'] }}" wire:model="{{ $field['wire'] }}">
    <span class="text-muted mb-4">{{ isset($field['desc']) ? __($field['desc']) : null }}</span>
    @if ($errors->has($field['name']))
        <small class="help-block">{{ $errors->first($field['name']) }}</small>
    @endif
</div>
