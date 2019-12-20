<div class="nav-tabs-custom" id="filter">
    <ul class="nav nav-tabs" role="tablist">
        @php $i = 1; @endphp
        @foreach($groups as $group_id => $group_item)
            <li class="nav-item @if($i == 1) active @endif">
                <a href="{{ '#tab_' . $group_id }}" data-toggle="tab" aria-expanded="true" 
                    class="nav-link" role="tab">
                    {{ $group_item }}
                </a>
            </li>
            @php $i++; @endphp
        @endforeach
        <li class="nav-item ml-auto">
            <a class="nav-link" href="#" id="reset-filter">Сброс</a>
        </li>
    </ul>
    <div class="tab-content">
        @if(!empty($attrs))
            @php $i = 1; @endphp
            @foreach($groups as $group_id => $group_item)
                <div class="tab-pane @if ($i == 1) active @endif" id="{{ 'tab_' . $group_id}}" role="tabpanel">
                    @foreach($attrs[$group_id] as $attr_id => $value)
                        @php
                        if (!empty($filter) && in_array($attr_id, $filter)) {
                            $checked = ' checked';
                        } else {
                            $checked = null;
                        }
                        $i++;
                        @endphp
                        <div class="form-group">
                            <label>
                                <input type="radio" name="atrrs[{{$group_id}}]" 
                                    value="{{ $attr_id }}" {{ $checked }} 
                                />{{ $value }}
                            </label>
                        </div>
                    @endforeach
                </div>
            @endforeach
        @endif
    </div>
</div>