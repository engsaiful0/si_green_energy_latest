{{-- One repeater item. Expects: $repeaterName, $repeater, $index, $row. --}}
<div class="card mb-2 repeater-row" data-repeater-row>
    <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
        <strong class="small">{{ $repeater['item_label'] ?? 'Item' }} <span data-row-number></span></strong>
        <div class="btn-group btn-group-sm">
            <button type="button" class="btn btn-outline-secondary" data-move="up" title="Move up"><i class="fas fa-arrow-up"></i></button>
            <button type="button" class="btn btn-outline-secondary" data-move="down" title="Move down"><i class="fas fa-arrow-down"></i></button>
            <button type="button" class="btn btn-outline-danger" data-remove-row title="Remove"><i class="fas fa-trash"></i></button>
        </div>
    </div>
    <div class="card-body pb-0">
        <div class="row">
            @foreach($repeater['fields'] as $fieldName => $field)
            <div class="{{ in_array($field['type'] ?? 'text', ['textarea', 'image']) ? 'col-12' : 'col-md-6' }}">
                @include('admin.content._field', [
                    'field' => $field,
                    'name' => "content[{$repeaterName}][{$index}][{$fieldName}]",
                    'fileName' => "files[{$repeaterName}][{$index}][{$fieldName}]",
                    'removeName' => "remove[{$repeaterName}][{$index}][{$fieldName}]",
                    'value' => $row[$fieldName] ?? '',
                ])
            </div>
            @endforeach
        </div>
    </div>
</div>
