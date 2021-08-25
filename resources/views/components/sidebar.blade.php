<aside id="main-sidebar" class="dt-sidebar">
    <div class="dt-sidebar__container">

        <!-- Sidebar Navigation -->
        <ul class="dt-side-nav">

          @if (Session::get('menu'))
            @foreach (Session::get('menu') as $menu)
                @if ($menu -> children -> isEmpty())
                  @if ($menu -> type == 1)
                    <li class="dt-side-nav__item dt-side-nav__header">
                        <span class="dt-side-nav__text">{{ $menu -> divider_name }}</span>
                    </li>
                  @else
                    <li class="dt-side-nav__item {{ request()->is($menu -> url) ? 'selected' : '' }}">
                      <a href="{{ url($menu -> url) }}" class="dt-side-nav__link {{ request()->is($menu -> url) ? 'active' : '' }}" title="{{ $menu -> module_name }}"> <i
                              class="{{ $menu -> icon_class }}"></i>
                          <span class="dt-side-nav__text">{{ $menu -> module_name }}</span> </a>
                    </li>
                  @endif
                @else
                  <li class="dt-side-nav__item 
                    @foreach ($menu -> children as $submenu)
                      {{ request()->is($submenu -> url) ? 'open' : '' }}
                    @endforeach
                  ">
                    <a href="javascript:void(0)" class="dt-side-nav__link dt-side-nav__arrow" title="Dashboard">
                        <i class="{{ $menu -> icon_class }}"></i> <span class="dt-side-nav__text">{{ $menu -> module_name }}</span>
                    </a>
    
                    <!-- Sub-menu -->
                    <ul class="dt-side-nav__sub-menu">
                      @foreach ($menu -> children as $submenu)
                        <li class="dt-side-nav__item {{ request()->is($submenu -> url) ? 'selected' : '' }}">
                            <a href="{{ url($submenu -> url) }}" class="dt-side-nav__link {{ request()->is($submenu -> url) ? 'active' : '' }}" title="Crypto"> <i
                                    class="{{ $submenu -> icon_class }}"></i>
                                <span class="dt-side-nav__text">{{ $submenu -> module_name }}</span> </a>
                        </li>  
                      @endforeach  
                    </ul>
                </li>
              @endif
            @endforeach
          @else
            
          @endif

        </ul>
        <!-- /sidebar navigation -->

    </div>
</aside>
