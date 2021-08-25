<ol class="dd-list">
    @forelse ($menuItems as $item)
        <li class="dd-item" data-id="{{ $item -> id }}">
            <div class="pull-right item-action">
                @if (permission('menu-module-delete'))
                    <button type="button" onclick="deleteItem('{{ $item->id }}')" class="btn btn-danger btn-sm float-right item_action">
                        <i class="fas fa-trash"></i>
                    </button>
                    <form action="{{ route('menu.module.delete', ['module' => $item -> id]) }}" method="POST" id="delete_form_{{ $item -> id }}" style="display: none">
                        @csrf
                        @method('DELETE')
                    </form>
                @endif
                @if (permission('menu-module-edit'))
                    <a href="{{ route('menu.module.edit', ['menu' => $item -> menu_id, 'module'=> $item -> id]) }}" class="btn btn-primary btn-sm float-right item_action mr-2"><i class="fas fa-edit"></i></a>
                @endif
            </div>
            <div class="dd-handle">
                @if ($item -> type == 1)
                    <strong>Divider: {{ $item -> divider_name }}</strong>
                @else
                    <span>{{ $item -> module_name }}</span> <small class="url">{{ $item -> url }}</small>
                @endif
            </div>
            @if (!$item -> children ->isEmpty())
                <x-menu-builder :menuItems="$item->children"/>
            @endif
        </li>
    @empty
    <div class="text-center">
        <strong class="text-danger">No menu item found</strong>
    </div>
    @endforelse
</ol>
