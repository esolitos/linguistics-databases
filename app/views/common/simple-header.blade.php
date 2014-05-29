@section("header")
  <div class="header">
    <div class="navbar-top sticky fixed">
      <nav id="main-menu" class="top-bar" data-topbar data-options="sticky_on:large">

        <ul class="title-area">
            <li class="name">
              <h1><a href="/">Linguistics DB</a></h1>
            </li>
             <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
            <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
          </ul>
          
          <section class="top-bar-section">
            <!-- Right Nav Section -->
            {{ Menu::handler('top-menu-right') }}
            <!-- Left Nav Section -->
            {{ Menu::handler('top-menu-left') }}
          </section>
      </nav>
    </div>
  </div>
@show