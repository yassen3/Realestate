<nav class="sidebar">
    <div class="sidebar-header">
      <a href="#" class="sidebar-brand">
        Noble<span>Admin</span>
      </a>
      <div class="sidebar-toggler not-active">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
    <div class="sidebar-body">
      <ul class="nav">
        <li class="nav-item nav-category">Main</li>
        <li class="nav-item">
          <a href="{{route('AdminDashboard')}}" class="nav-link">
            <i class="link-icon" data-feather="box"></i>
            <span class="link-title">Dashboard</span>
          </a>
        </li>
        <li class="nav-item nav-category">RealEstate</li>
        @if (Auth::user()->can(	'type.menu'))

        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#emails" role="button" aria-expanded="false" aria-controls="emails">
            <i class="link-icon" data-feather="home"></i>
            <span class="link-title">Property Type</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
          </a>
          <div class="collapse" id="emails">
            <ul class="nav sub-menu">
              <li class="nav-item">
                @if (Auth::user()->can(	'type.menu'))
                <a href="{{route("all.type")}}" class="nav-link">All Types</a>
              </li>
              @endif
              <li class="nav-item">
                @if (Auth::user()->can(	'type.menu'))
                <a href="{{route('add.type')}}" class="nav-link">Add Type</a>
              </li>
              @endif
            </ul>
          </div>
        </li>
        @endif
        @if (Auth::user()->can('amenities.menu'))
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#amenities" role="button" aria-expanded="false" aria-controls="emails">
              <i class="link-icon" data-feather="activity"></i>
              <span class="link-title">Amenities</span>
              <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="amenities">
              <ul class="nav sub-menu">
                @if (Auth::user()->can('all.amenities'))
                <li class="nav-item">
                  <a href="{{route("all.amenities")}}" class="nav-link">All Amenities</a>
                </li>
                @endif

              </ul>
            </div>
          </li>
          @endif
          @if (Auth::user()->can('property.menu'))
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#property" role="button" aria-expanded="false" aria-controls="emails">
              <i class="link-icon" data-feather="mail"></i>
              <span class="link-title">Property</span>
              <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="property">
              <ul class="nav sub-menu">
                @if (Auth::user()->can('all.property'))
                <li class="nav-item">
                  <a href="{{route("all.properties")}}" class="nav-link">All Property</a>
                </li>
                @endif
                @if (Auth::user()->can('add.property'))
                <li class="nav-item">
                  <a href="{{route("add.properties")}}" class="nav-link">Add Property</a>
                </li>
                @endif
              </ul>
            </div>
          </li>
          @endif
          @if (Auth::user()->can('state.menu'))
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#state" role="button" aria-expanded="false" aria-controls="emails">
              <i class="link-icon" data-feather="map"></i>
              <span class="link-title">Property State</span>
              <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="state">
              <ul class="nav sub-menu">
                @if (Auth::user()->can('state.all'))
                <li class="nav-item">
                  <a href="{{route("all.state")}}" class="nav-link">All State</a>
                </li>
                @endif
                @if (Auth::user()->can('state.add'))
                <li class="nav-item">
                  <a href="{{route("add.state")}}" class="nav-link">Add State</a>
                </li>
                @endif
              </ul>
            </div>
          </li>
          @endif
        <li class="nav-item">
          <a href="{{route('admin.package.history')}}" class="nav-link">
            <i class="link-icon" data-feather="calendar"></i>
            <span class="link-title">Package History</span>
          </a>
        </li>
        @if (Auth::user()->can('comment.menu'))
        <li class="nav-item">
            <a href="{{route('admin.property.message')}}" class="nav-link">
              <i class="link-icon" data-feather="calendar"></i>
              <span class="link-title">Property Message</span>
            </a>
          </li>
          @endif
          @if (Auth::user()->can('testimonial.menu'))
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#testimonials" role="button" aria-expanded="false" aria-controls="emails">
              <i class="link-icon" data-feather="map"></i>
              <span class="link-title">Testimonial Manage</span>
              <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="testimonials">
              <ul class="nav sub-menu">
                @if (Auth::user()->can('all.testimonial'))
                <li class="nav-item">
                  <a href="{{route("all.testimonials")}}" class="nav-link">All Testimonials</a>
                </li>
                @endif
                @if (Auth::user()->can('add.testimonial'))
                <li class="nav-item">
                  <a href="{{route("add.testimonials")}}" class="nav-link">Add Testimonial</a>
                </li>
                @endif
              </ul>
            </div>
          </li>
          @endif
        <li class="nav-item nav-category">User All Function</li>
        @if (Auth::user()->can('agent.menu'))
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#uiComponents" role="button" aria-expanded="false" aria-controls="uiComponents">
            <i class="link-icon" data-feather="feather"></i>
            <span class="link-title">Manage Agent</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
          </a>
          <div class="collapse" id="uiComponents">
            <ul class="nav sub-menu">
                @if (Auth::user()->can('all.agent'))
              <li class="nav-item">
                <a href="{{route('all.agent')}}" class="nav-link">All Agent</a>
              </li>
              @endif
              @if (Auth::user()->can('add.agent'))
              <li class="nav-item">
                <a href="{{route('add.agent')}}" class="nav-link">Add Agent</a>
              </li>
              @endif
            </ul>
          </div>
        </li>
        @endif
        @if (Auth::user()->can('category.menu'))
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#blogcategory" role="button" aria-expanded="false" aria-controls="uiComponents">
              <i class="link-icon" data-feather="feather"></i>
              <span class="link-title">Blog Category</span>
              <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="blogcategory">
              <ul class="nav sub-menu">
                @if (Auth::user()->can('all.category'))
                <li class="nav-item">
                  <a href="{{route('all.blog.category')}}" class="nav-link">All Blog Category</a>
                </li>
                @endif
              </ul>
            </div>
          </li>
          @endif
          @if (Auth::user()->can('post.menu'))
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#blogpost" role="button" aria-expanded="false" aria-controls="uiComponents">
              <i class="link-icon" data-feather="feather"></i>
              <span class="link-title">Blog Post</span>
              <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="blogpost">
              <ul class="nav sub-menu">
                @if (Auth::user()->can('all.post'))
                <li class="nav-item">
                  <a href="{{route('all.post')}}" class="nav-link">All Posts</a>
                </li>
                @endif
                @if (Auth::user()->can('add.post'))
                <li class="nav-item">
                  <a href="{{route('add.post')}}" class="nav-link">Add Post</a>
                </li>
                @endif
              </ul>
            </div>
          </li>
          @endif
          @if (Auth::user()->can('comment.menu'))
          <li class="nav-item">
            <a href="{{route('admin.blog.comment')}}" class="nav-link">
              <i class="link-icon" data-feather="calendar"></i>
              <span class="link-title">Blog Comment</span>
            </a>
          </li>
          @endif
          @if (Auth::user()->can('smtp.menu'))
          <li class="nav-item">
            <a href="{{route('smtp.setting')}}" class="nav-link">
              <i class="link-icon" data-feather="calendar"></i>
              <span class="link-title">SMTP Setting</span>
            </a>
          </li>
          @endif
          @if (Auth::user()->can('site.menu'))
          <li class="nav-item">
            <a href="{{route('site.setting')}}" class="nav-link">
              <i class="link-icon" data-feather="calendar"></i>
              <span class="link-title">Site Setting</span>
            </a>
          </li>
          @endif
          <li class="nav-item nav-category">Role & Permission</li>
          @if (Auth::user()->can('permission.menu'))
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#advancedUI" role="button" aria-expanded="false" aria-controls="advancedUI">
            <i class="link-icon" data-feather="anchor"></i>
            <span class="link-title">Role & Permission</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
          </a>
          <div class="collapse" id="advancedUI">
            <ul class="nav sub-menu">
                @if (Auth::user()->can('all.permission'))
              <li class="nav-item">
                <a href="{{route('all.permission')}}" class="nav-link">All Permission</a>
              </li>
              @endif
              @if (Auth::user()->can('all.role'))
              <li class="nav-item">
                <a href="{{route('all.role')}}" class="nav-link">ِAll Roles</a>
              </li>
              @endif
              @if (Auth::user()->can('add.roles.permission'))
              <li class="nav-item">
                <a href="{{route('add.roles.permission')}}" class="nav-link">Add Roles In Permission</a>
              </li>
              @endif
              @if (Auth::user()->can('all.roles.permission'))
              <li class="nav-item">
                <a href="{{route('all.roles.permission')}}" class="nav-link">All Roles In Permission</a>
              </li>
              @endif
            </ul>
          </div>
        </li>
        @endif
        @if (Auth::user()->can('Admin.menu'))
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#admin" role="button" aria-expanded="false" aria-controls="admin">
              <i class="link-icon" data-feather="anchor"></i>
              <span class="link-title">Manage Admin User</span>
              <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="admin">
              <ul class="nav sub-menu">
                @if (Auth::user()->can('all.admin'))
                <li class="nav-item">
                  <a href="{{ route('all.admin') }}" class="nav-link">All Admin</a>
                </li>
                @endif
                @if (Auth::user()->can('add.admin'))
                <li class="nav-item">
                 <a href="{{ route('add.admin') }}" class="nav-link">Add Admin </a>
                </li>
                @endif
              </ul>
            </div>
          </li>
          @endif

        <li class="nav-item nav-category">Docs</li>
        <li class="nav-item">
          <a href="#" target="_blank" class="nav-link">
            <i class="link-icon" data-feather="hash"></i>
            <span class="link-title">Documentation</span>
          </a>
        </li>
      </ul>
    </div>
  </nav>
