<div class="header-navbar navbar-expand-sm navbar navbar-horizontal navbar-fixed navbar-light navbar-without-dd-arrow"
     role="navigation" data-menu="menu-wrapper">
    <div class="navbar-header d-xl-none d-block">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <div class="brand-logo"></div>
                    <h2 class="brand-text mb-0">{{ __(config('app.name')) }}</h2>
                </a>
            </li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i
                        class="bx bx-x d-block d-xl-none font-medium-4 primary toggle-icon"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <!-- Horizontal menu content-->
    <div class="navbar-container main-menu-content" data-menu="menu-container">
        <!-- include ../../../includes/mixins-->
        <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation" data-icon-style="filled">
            <li>
                <a class="nav-link no-child" href="#" data-toggle=""><i class="menu-livicon"
                                                                        data-icon="desktop"></i><span
                        data-i18n="Dashboard"></span></a>
            </li>
            @can("setup", \App\Models\Menu::class)
                <li class="dropdown nav-item" data-menu="dropdown">
                    <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="menu-livicon"
                          data-icon="gears"></i><span>Setup</span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a
                                class="dropdown-item align-items-center dropdown-toggle" href="#"
                                data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>Organizational Setup</a>
                            <ul class="dropdown-menu">
                                {{-- A --}}
                                @can('approval-team-list')
                                    <li data-menu="">
                                        <a class="dropdown-item align-items-center"
                                           href="{{ route('approval-teams.index') }}" data-toggle="dropdown"><i
                                                class="bx bx-right-arrow-alt"></i>Approval Teams</a>
                                    </li>
                                @endcan

                                {{-- B --}}
                                @can('brand-list')
                                    <li data-menu="">
                                        <a class="dropdown-item align-items-center" href="{{ route('brands.index') }}"
                                           data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>Brands</a>
                                    </li>
                                @endcan

                                {{-- C --}}
                                @can('category-list')
                                    <li data-menu="">
                                        <a class="dropdown-item align-items-center"
                                           href="{{ route('categories.index') }}"
                                           data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>Categories</a>
                                    </li>
                                @endcan
                                @can('cost-center-list')
                                    <li data-menu="">
                                        <a class="dropdown-item align-items-center"
                                           href="{{ route('cost-center.index') }}" data-toggle="dropdown"><i
                                                class="bx bx-right-arrow-alt"></i>Cost Center</a>
                                    </li>
                                @endcan
                                @can('company-list')
                                <li data-menu="">
                                    <a class="dropdown-item align-items-center"
                                       href="{{ route('companies.index') }}" data-toggle="dropdown"><i
                                            class="bx bx-right-arrow-alt"></i>Company</a>
                                </li>
                                @endcan

                                {{-- D --}}
                                @can('department-list')
                                    <li data-menu="">
                                        <a class="dropdown-item align-items-center"
                                           href="{{ route('departments.index') }}" data-toggle="dropdown"><i
                                                class="bx bx-right-arrow-alt"></i>Departments</a>
                                    </li>
                                @endcan
                                @can('designation-list')
                                    <li data-menu="">
                                        <a class="dropdown-item align-items-center"
                                           href="{{ route('designations.index') }}" data-toggle="dropdown"><i
                                                class="bx bx-right-arrow-alt"></i>Designations</a>
                                    </li>
                                @endcan

                                {{-- E --}}
                                @can('employee-list')
                                    <li data-menu="">
                                        <a class="dropdown-item align-items-center" href="{{ route('employee.index') }}"
                                           data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>Employee</a>
                                    </li>
                                @endcan

                                {{-- F --}}
                                {{-- G --}}
                                {{-- H --}}

                                {{-- I --}}
                                @can('item-list')
                                    <li data-menu="">
                                        <a class="dropdown-item align-items-center" href="{{ route('items.index') }} "
                                           data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>Items</a>
                                    </li>
                                @endcan

                                {{-- J --}}
                                {{-- K --}}
                                {{-- L --}}
                                {{-- M --}}
                                {{-- N --}}
                                {{-- O --}}

                                @if(auth()->user()->type =='hq-admin')
                                    <li data-menu="">
                                        <a class="dropdown-item align-items-center" href="{{ url('/process-info') }}"
                                           data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>Process Info</a>
                                    </li>
                                @endif
                                {{-- P --}}
                                {{-- Q --}}

                                {{-- R --}}
                                @can('role-list')
                                    <li data-menu="">
                                        <a class="dropdown-item align-items-center" href="{{ route('roles.index') }}"
                                           data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>Roles</a>
                                    </li>
                                @endcan

                                {{-- S --}}
                                {{-- T --}}

                                {{-- U --}}
                                @can('uom-list')
                                    <li data-menu="">
                                        <a class="dropdown-item align-items-center" href="{{ route('uoms.index') }}"
                                           data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>UoMs</a>
                                    </li>
                                @endcan

                                {{-- V --}}
                                @can('vendor-list')
                                    <li data-menu="">
                                        <a class="dropdown-item align-items-center" href="{{ route('vendors.index') }}"
                                           data-toggle="dropdown"><i class="bx bx-right-arrow-alt"></i>Vendors</a>
                                    </li>
                                @endcan

                            </ul>
                        </li>
                    </ul>
                </li>

            @endcan
            <li class="dropdown nav-item" data-menu="dropdown">
                <a class="dropdown-toggle nav-link" href="{{ route('requisitions.index') }}"
                   data-toggle="dropdown">
                    <i class="menu-livicon" data-icon="notebook"></i><span>PR</span></a>
                <ul class="dropdown-menu">
                    <li class="dropdown " data-menu=""><a class="dropdown-item align-items-center "
                                                          href="{{ route('requisitions.index') }}"><i class="bx bx-right-arrow-alt"></i>PR List</a>
                    </li>
                </ul>
            </li>


            {{-- @can('csPermission',\App\Models\Menu::class) --}}
            <li class="dropdown nav-item" data-menu="dropdown">
                <a class="dropdown-toggle nav-link cursor-pointer" data-toggle="dropdown">
                    <i class="menu-livicon livicon" data-icon="balance"></i><span>CS</span></a>
                <ul class="dropdown-menu">
                    <li class="dropdown " data-menu=""><a class="dropdown-item align-items-center"
                                                            href="{{ url('cs-details') }}"><i
                                class="bx bx-right-arrow-alt"></i>CS List</a>
                    </li>
                </ul>
            </li>
            {{-- @endcan --}} 

            {{-- @can('purchaseOrder',\App\Models\Menu::class) --}}
            <li class="dropdown nav-item" data-menu="dropdown">
                <a class="dropdown-toggle nav-link cursor-pointer" data-toggle="dropdown">
                    <i class="menu-livicon livicon" data-icon="list"></i><span>PO</span></a>
                <ul class="dropdown-menu">
                    <li class="dropdown " data-menu=""><a class="dropdown-item align-items-center"
                        href="{{ url('purchase-orders') }}"><i class="bx bx-right-arrow-alt"></i>PO List</a>
                    </li>
                </ul>
            </li>
            {{-- @endcan --}}
            @can('grn',\App\Models\Menu::class)
            <li class="dropdown nav-item" data-menu="dropdown">
                <a class="dropdown-toggle nav-link cursor-pointer"
                   data-toggle="dropdown">
                    <i class="menu-livicon" data-icon="thumbnails-big"></i><span>GRN</span></a>
                <ul class="dropdown-menu">
                    <li class="dropdown " data-menu=""><a class="dropdown-item align-items-center "
                       href="{{ route('grn.index') }}"><i class="bx bx-right-arrow-alt"></i>GRN List</a>
                    </li>
                </ul>
            </li>
            @endcan

            @can('report',\App\Models\Menu::class)
            <li class="dropdown nav-item" data-menu="dropdown">
                <a class="dropdown-toggle nav-link cursor-pointer"
                   data-toggle="dropdown">
                    <i class="menu-livicon" data-icon="notebook"></i><span>Report</span></a>
                <ul class="dropdown-menu">
                    <li class="dropdown " data-menu=""><a class="dropdown-item align-items-center "
                       href="{{ url('requisition-report') }}"><i class="bx bx-right-arrow-alt"></i>PR Report</a>
                    </li>
                    <li class="dropdown " data-menu=""><a class="dropdown-item align-items-center "
                        href="{{ url('purchase-order-report') }}"><i class="bx bx-right-arrow-alt"></i>PO Report</a>
                     </li>
                </ul>
            </li>
            @endcan
        </ul>
    </div>
</div>
