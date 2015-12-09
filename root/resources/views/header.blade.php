       <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navbar-collapse"><i class="navbar-icon fa fa-bars"></i></button>

      </div> <!-- / .navbar-header -->

      <div id="main-navbar-collapse" class="collapse navbar-collapse main-navbar-collapse">
        <div>
          <ul class="nav navbar-nav">
            <li>
              <a href="#">Home</a>
            </li>
            
          </ul> <!-- / .navbar-nav -->

          <div class="right clearfix">
            <ul class="nav navbar-nav pull-right right-navbar-nav">

<!-- 3. $NAVBAR_ICON_BUTTONS =======================================================================

              Navbar Icon Buttons

              NOTE: .nav-icon-btn triggers a dropdown menu on desktop screens only. On small screens .nav-icon-btn acts like a hyperlink.

              Classes:
              * 'nav-icon-btn-info'
              * 'nav-icon-btn-success'
              * 'nav-icon-btn-warning'
              * 'nav-icon-btn-danger' 
-->
              <li class="nav-icon-btn nav-icon-btn-danger dropdown">
                <a href="#notifications" class="dropdown-toggle" data-toggle="dropdown">
                  <span class="label"><?php echo count($notifications); ?></span>
                  <i class="nav-icon fa fa-bullhorn"></i>
                  <span class="small-screen-text">Notifications</span>
                </a>

                <!-- NOTIFICATIONS -->
                
                <!-- Javascript -->
                <script>
                  init.push(function () {
                    $('#main-navbar-notifications').slimScroll({ height: 250 });
                  });
                </script>
                <!-- / Javascript -->

                <div class="dropdown-menu widget-notifications no-padding" style="width: 300px">
                  <div class="notifications-list" id="main-navbar-notifications">
                  @foreach($notifications as $value)
                    <div class="notification">
                      <div class="notification-title text-danger">License expiry</div>
                      <div class="notification-description"><strong>{{$value->message}}</strong></div>
                      <div class="notification-ago"><?php  
                          $datetime = $value->sent_on; $full = false;
                          $now = new DateTime;
                          $ago = new DateTime($datetime);
                          $diff = $now->diff($ago);

                          $diff->w = floor($diff->d / 7);
                          $diff->d -= $diff->w * 7;

                          $string = array(
                              'y' => 'year',
                              'm' => 'month',
                              'w' => 'week',
                              'd' => 'day',
                              'h' => 'hour',
                              'i' => 'minute',
                              's' => 'second',
                          );
                          foreach ($string as $k => &$v) {
                              if ($diff->$k) {
                                  $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
                              } else {
                                  unset($string[$k]);
                              }
                          }

                          if (!$full) $string = array_slice($string, 0, 1);
                          echo $string ? implode(', ', $string) . ' ago' : 'just now';
                        
                      ?>
                      </div>
                      <div class="notification-icon fa fa-hdd-o bg-danger"></div>
                    </div> <!-- / .notification -->
                  @endforeach
                    <!-- <div class="notification">
                      <div class="notification-title text-info">EAZYPAPER</div>
                      <div class="notification-description">You have <strong>9</strong> new renewals.</div>
                      <div class="notification-ago">12h ago</div>
                      <div class="notification-icon fa fa-truck bg-info"></div>
                    </div>  --><!-- / .notification -->

                    

                  </div> <!-- / .notifications-list -->
                  <a href="#" class="notifications-link">MORE NOTIFICATIONS</a>
                </div> <!-- / .dropdown-menu -->
              </li>
              <!-- <li class="nav-icon-btn nav-icon-btn-success dropdown">
                <a href="#messages" class="dropdown-toggle" data-toggle="dropdown">
                  <span class="label">0</span>
                  <i class="nav-icon fa fa-envelope"></i>
                  <span class="small-screen-text">Income messages</span>
                </a>
              
                MESSAGES
                
                Javascript
                <script>
                  init.push(function () {
                    $('#main-navbar-messages').slimScroll({ height: 250 });
                  });
                </script>
                / Javascript
              
                <div class="dropdown-menu widget-messages-alt no-padding" style="width: 300px;">
                  <div class="messages-list" id="main-navbar-messages">
              
                    
              
                  </div> / .messages-list
                  <a href="#" class="messages-link">MORE MESSAGES</a>
                </div> / .dropdown-menu
              </li> -->
<!-- /3. $END_NAVBAR_ICON_BUTTONS -->

          <!--     <li>
            <form class="navbar-form pull-left">
              <input type="text" class="form-control" placeholder="Search">
            </form>
          </li> -->

              <li class="dropdown">
                <a href="#" class="dropdown-toggle user-menu" data-toggle="dropdown">
                  <img src="{{ asset("/themes/nbc/assets/demo/avatars/nbc.jpg") }}" alt="">
                  <span>Nigerian Bottling Company</span>
                </a>

                <ul class="dropdown-menu">
                  <li><a href="{{ url('profile') }}">Profile</a></li>
                 <!--  <li><a href="#">Account <span class="badge badge-primary pull-right">new</span></a></li>
                 <li><a href="#"><i class="dropdown-icon fa fa-cog"></i>&nbsp;&nbsp;Settings</a></li> -->
                  <li class="divider"></li>
                  @if(Session::get('role') == 1)
                    <li><a href="{{ url('logout') }}"><i class="dropdown-icon fa fa-power-off"></i>&nbsp;&nbsp;Log Out</a></li>
                  @endif
                  @if(Session::get('role') == 2)
                  <li><a href="{{ url('client/logout') }}"><i class="dropdown-icon fa fa-power-off"></i>&nbsp;&nbsp;Log Out</a></li>
                  @endif
                </ul>
              </li>
            </ul> <!-- / .navbar-nav -->
          </div> <!-- / .right -->
        </div>
      </div> <!-- / #main-navbar-collapse -->
    </div> <!-- / .navbar-inner -->
  </div> <!-- / #main-navbar -->