<?php


if (session_status() == PHP_SESSION_NONE) {
  session_start();
}


if (!isset($_SESSION["login"])) {
  header("location: ./../../login.php");
  exit(); // Menghentikan eksekusi skrip setelah redirect
}

require_once "./../../config/autoload.php";
$conn = new Database($host, $user, $pass, $database);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard Admin</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="./../../assets/bootstrap/plugins/fontawesome-free/css/all.min.css" />
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="./../../assets/bootstrap/plugins/overlayScrollbars/css/OverlayScrollbars.min.css" />
  <!-- Theme style -->
  <link rel="stylesheet" href="./../../assets/bootstrap/dist/css/adminlte.min.css" />

  <!-- SummerNote -->
  <link rel="stylesheet" href="./../../assets/bootstrap/dist/css/adminlte.min.css" />
  <link rel="stylesheet" href="./../../assets/bootstrap/plugins/summernote/summernote-bs4.min.css" />

  <!-- Data Table -->
  <link rel="stylesheet" href="./../../assets/bootstrap/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css" />
  <link rel="stylesheet" href="./../../assets/bootstrap/plugins/datatables-responsive/css/responsive.bootstrap4.min.css" />
  <link rel="stylesheet" href="./../../assets/bootstrap/plugins/datatables-buttons/css/buttons.bootstrap4.min.css" />

  <link rel="stylesheet" href="./../../assets/bootstrap/plugins/fullcalendar/main.css">

  <script src="./../../assets/sweetalert/sweetalert2.all.js"></script>


</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">


  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="?page=dashboard" class="nav-link">Home</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="mr-2 d-none d-lg-inline text-gray-600 small">Admin</span>
          <i class="fas fa-user img-profile rounded-circle"></i>
        </a>
        <!-- Dropdown - User Information -->
        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="./../../config/models/logout.php">
            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
            Logout
          </a>
        </div>
      </li>
    </ul>
  </nav>

  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.html" class="brand-link">
      <img src="./../../assets/img/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: 0.8" width="100px" />
      <span class="brand-text font-weight-light">Admin RAPI</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- SidebarSearch Form -->
      <div class="form-inline mt-2  ">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search" />
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="?page=dashboard" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>



          <li class="nav-item">
            <a href="" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Forms
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="?page=create-rapat" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create Rapat</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Add Users
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="?page=add-user" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add User</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="" class="nav-link">
              <i class="nav-icon fas fa-print"></i>
              <p>
                Upload Notulen
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="?page=uplaod-notulen" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Upload Berkas</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- End of Topbar -->
    <?php
    if (@$_GET["page"] == "dashboard" || @$_GET["page"] == "") {
      require "./components/dashboard.php";
    } else if (@$_GET["page"]  == "create-rapat") {
      require "./components/create_rapat.php";
    } else if (@$_GET["page"] == "add-user") {
      require "./components/add_user.php";
    } else if (@$_GET["page"] == "detail-rapat") {
      require "./components/detail_rapat.php";
    } else if (@$_GET["page"] == "uplaod-notulen") {
      require "./components/upload_notulen.php";
    } else if (@$_GET["page"] == "calender") {
      require "./components/calender.php";
    } else if (@$_GET["page"] == "edit-detail-rapat") {
      require "./components/edit-detail-rapat.php";
    } else {
      require "./components/not_found.php";
    }
    ?>


  </div>
  <!-- /.content-wrapper -->



  <!-- Main Footer -->
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->
  <!-- jQuery -->
  <script src="./../../assets/bootstrap/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="./../../assets/bootstrap/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="./../../assets/bootstrap/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="./../../assets/bootstrap/dist/js/adminlte.js"></script>

  <!-- PAGE PLUGINS -->
  <!-- jQuery Mapael -->
  <script src="./../../assets/bootstrap/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
  <script src="./../../assets/bootstrap/plugins/raphael/raphael.min.js"></script>
  <script src="./../../assets/bootstrap/plugins/jquery-mapael/jquery.mapael.min.js"></script>
  <script src="./../../assets/bootstrap/plugins/jquery-mapael/maps/usa_states.min.js"></script>
  <!-- ChartJS -->
  <script src="./../../assets/bootstrap/plugins/chart.js/Chart.min.js"></script>

  <!-- AdminLTE for demo purposes -->

  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="./../../assets/bootstrap/dist/js/pages/dashboard2.js"></script>

  <!-- Summernote -->
  <script src="./../../assets/bootstrap/plugins/summernote/summernote-bs4.min.js"></script>
  <script src="./../../assets/js/summernote.js"></script>


  <!-- DataTables  & Plugins -->
  <script src="./../../assets/bootstrap/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="./../../assets/bootstrap/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="./../../assets/bootstrap/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="./../../assets/bootstrap/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="./../../assets/bootstrap/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="./../../assets/bootstrap/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="./../../assets/bootstrap/plugins/jszip/jszip.min.js"></script>
  <script src="./../../assets/bootstrap/plugins/pdfmake/pdfmake.min.js"></script>
  <script src="./../../assets/bootstrap/plugins/pdfmake/vfs_fonts.js"></script>
  <script src="./../../assets/bootstrap/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="./../../assets/bootstrap/plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="./../../assets/bootstrap/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
  <script src="./../../assets/js/datatable.js"></script>

  <!-- Hapus  -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const hapusButtons = document.querySelectorAll('.hapus-button');
      const hapusLink = document.getElementById('hapusLink');

      hapusButtons.forEach(button => {
        button.addEventListener('click', function() {
          const id = this.getAttribute('data-id');
          hapusLink.href = `index.php?id=${id}`;
        });
      });
    });
  </script>

  <!-- Calender -->
  <script src="./../../assets//bootstrap/plugins/moment/moment.min.js"></script>
  <script src="./../../assets/bootstrap/plugins/fullcalendar/main.js"></script>
  <script>
    $(function() {

      /* initialize the external events
       -----------------------------------------------------------------*/
      function ini_events(ele) {
        ele.each(function() {

          // create an Event Object (https://fullcalendar.io/docs/event-object)
          // it doesn't need to have a start or end
          var eventObject = {
            title: $.trim($(this).text()) // use the element's text as the event title
          }

          // store the Event Object in the DOM element so we can get to it later
          $(this).data('eventObject', eventObject)

          // make the event draggable using jQuery UI
          $(this).draggable({
            zIndex: 1070,
            revert: true, // will cause the event to go back to its
            revertDuration: 0 //  original position after the drag
          })

        })
      }

      ini_events($('#external-events div.external-event'))

      /* initialize the calendar
       -----------------------------------------------------------------*/
      //Date for the calendar events (dummy data)
      var date = new Date()
      var d = date.getDate(),
        m = date.getMonth(),
        y = date.getFullYear()

      var Calendar = FullCalendar.Calendar;
      var Draggable = FullCalendar.Draggable;

      var containerEl = document.getElementById('external-events');
      var checkbox = document.getElementById('drop-remove');
      var calendarEl = document.getElementById('calendar');

      // initialize the external events
      // -----------------------------------------------------------------

      new Draggable(containerEl, {
        itemSelector: '.external-event',
        eventData: function(eventEl) {
          return {
            title: eventEl.innerText,
            backgroundColor: window.getComputedStyle(eventEl, null).getPropertyValue('background-color'),
            borderColor: window.getComputedStyle(eventEl, null).getPropertyValue('background-color'),
            textColor: window.getComputedStyle(eventEl, null).getPropertyValue('color'),
          };
        }
      });

      var calendar = new Calendar(calendarEl, {
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        themeSystem: 'bootstrap',
        //Random default events
        events: [{
            title: 'All Day Event',
            start: new Date(y, m, 1),
            backgroundColor: '#f56954', //red
            borderColor: '#f56954', //red
            allDay: true
          },
          {
            title: 'Long Event',
            start: new Date(y, m, d - 5),
            end: new Date(y, m, d - 2),
            backgroundColor: '#f39c12', //yellow
            borderColor: '#f39c12' //yellow
          },
          {
            title: 'Meeting',
            start: new Date(y, m, d, 10, 30),
            allDay: false,
            backgroundColor: '#0073b7', //Blue
            borderColor: '#0073b7' //Blue
          },
          {
            title: 'Lunch',
            start: new Date(y, m, d, 12, 0),
            end: new Date(y, m, d, 14, 0),
            allDay: false,
            backgroundColor: '#00c0ef', //Info (aqua)
            borderColor: '#00c0ef' //Info (aqua)
          },
          {
            title: 'Birthday Party',
            start: new Date(y, m, d + 1, 19, 0),
            end: new Date(y, m, d + 1, 22, 30),
            allDay: false,
            backgroundColor: '#00a65a', //Success (green)
            borderColor: '#00a65a' //Success (green)
          },
          {
            title: 'Click for Google',
            start: new Date(y, m, 28),
            end: new Date(y, m, 29),
            url: 'https://www.google.com/',
            backgroundColor: '#3c8dbc', //Primary (light-blue)
            borderColor: '#3c8dbc' //Primary (light-blue)
          }
        ],
        editable: true,
        droppable: true, // this allows things to be dropped onto the calendar !!!
        drop: function(info) {
          // is the "remove after drop" checkbox checked?
          if (checkbox.checked) {
            // if so, remove the element from the "Draggable Events" list
            info.draggedEl.parentNode.removeChild(info.draggedEl);
          }
        }
      });

      calendar.render();
      // $('#calendar').fullCalendar()

      /* ADDING EVENTS */
      var currColor = '#3c8dbc' //Red by default
      // Color chooser button
      $('#color-chooser > li > a').click(function(e) {
        e.preventDefault()
        // Save color
        currColor = $(this).css('color')
        // Add color effect to button
        $('#add-new-event').css({
          'background-color': currColor,
          'border-color': currColor
        })
      })
      $('#add-new-event').click(function(e) {
        e.preventDefault()
        // Get value and make sure it is not null
        var val = $('#new-event').val()
        if (val.length == 0) {
          return
        }

        // Create events
        var event = $('<div />')
        event.css({
          'background-color': currColor,
          'border-color': currColor,
          'color': '#fff'
        }).addClass('external-event')
        event.text(val)
        $('#external-events').prepend(event)

        // Add draggable funtionality
        ini_events(event)

        // Remove event from text input
        $('#new-event').val('')
      })
    })
  </script>



</body>

</html>