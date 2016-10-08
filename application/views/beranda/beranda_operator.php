      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Dashboard
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
						
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>150</h3>
                  <p>Unit Kerja</p>
                </div>
                <div class="icon">
                  <i class="fa fa-sitemap"></i>
                </div>
                <a href="#" class="small-box-footer">
                  More info <i class="fa fa-arrow-circle-right"></i>
                </a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3>53<sup style="font-size: 20px"></sup></h3>
                  <p>Pegawai</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">
                  More info <i class="fa fa-arrow-circle-right"></i>
                </a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3>44</h3>
                  <p>Mesin</p>
                </div>
                <div class="icon">
                  <i class="fa fa-desktop"></i>
                </div>
                <a href="#" class="small-box-footer">
                  More info <i class="fa fa-arrow-circle-right"></i>
                </a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <h3>65</h3>
                  <p>Absen Manual</p>
                </div>
                <div class="icon">
                  <i class="fa fa-calendar"></i>
                </div>
                <a href="#" class="small-box-footer">
                  More info <i class="fa fa-arrow-circle-right"></i>
                </a>
              </div>
            </div><!-- ./col -->
          </div><!-- /.row -->
		  
		  <div class="row">
		  
			
			<div class="col-md-9">
              <div class="box box-primary">
                <div class="box-body no-padding">
                  <!-- THE CALENDAR -->
                  <div id="calendar"></div>
                </div><!-- /.box-body -->
              </div><!-- /. box -->
            </div><!-- /.col -->
			
			
			<div class="col-md-3">
              <!-- DIRECT CHAT PRIMARY -->
              <div class="box box-primary direct-chat direct-chat-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Recent Activity</h3>
                  <div class="box-tools pull-right">
                    <span data-toggle="tooltip" title="3 New Messages" class="badge bg-light-blue">3</span>
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <!--<button class="btn btn-box-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle"><i class="fa fa-comments"></i></button>-->
                    <!--<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <!-- Conversations are loaded here -->
                  <div class="direct-chat-messages">
                    <!-- Message. Default to the left -->
                    <div class="direct-chat-msg">
                      <div class="direct-chat-info clearfix">
                        <span class="direct-chat-name pull-left">Alexander Pierce</span>
                        <span class="direct-chat-timestamp pull-right">23 Jan 2:00 pm</span>
                      </div><!-- /.direct-chat-info -->
                      <img class="direct-chat-img" src="<?php echo base_url(); ?>asset/dist/img/user1-128x128.jpg" alt="message user image" /><!-- /.direct-chat-img -->
                      <div class="direct-chat-text">
                        Is this template really for free? That's unbelievable!
                      </div><!-- /.direct-chat-text -->
                    </div><!-- /.direct-chat-msg -->

                    <!-- Message to the right -->
                    <div class="direct-chat-msg right">
                      <div class="direct-chat-info clearfix">
                        <span class="direct-chat-name pull-right">Sarah Bullock</span>
                        <span class="direct-chat-timestamp pull-left">23 Jan 2:05 pm</span>
                      </div><!-- /.direct-chat-info -->
                      <img class="direct-chat-img" src="<?php echo base_url(); ?>asset/dist/img/user3-128x128.jpg" alt="message user image" /><!-- /.direct-chat-img -->
                      <div class="direct-chat-text">
                        You better believe it!
                      </div><!-- /.direct-chat-text -->
                    </div><!-- /.direct-chat-msg -->
                  </div><!--/.direct-chat-messages-->

                  <!-- Contacts are loaded here -->
                  <div class="direct-chat-contacts">
                    <ul class="contacts-list">
                      <li>
                        <a href="#">
                          <img class="contacts-list-img" src="<?php echo base_url(); ?>asset/dist/img/user1-128x128.jpg" />
                          <div class="contacts-list-info">
                            <span class="contacts-list-name">
                              Count Dracula
                              <small class="contacts-list-date pull-right">2/28/2015</small>
                            </span>
                            <span class="contacts-list-msg">How have you been? I was...</span>
                          </div><!-- /.contacts-list-info -->
                        </a>
                      </li><!-- End Contact Item -->
                    </ul><!-- /.contatcts-list -->
                  </div><!-- /.direct-chat-pane -->
                </div><!-- /.box-body -->
				
				<!--
                <div class="box-footer">
                  <form action="#" method="post">
                    <div class="input-group">
                      <input type="text" name="message" placeholder="Type Message ..." class="form-control" />
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-primary btn-flat">Send</button>
                      </span>
                    </div>
                  </form>
                </div><!-- /.box-footer-->
				
              </div><!--/.direct-chat -->
            </div><!-- /.col -->
			
						
			<div class="col-md-3">
              <div class="box box-solid">
                <div class="box-header with-border">
                  <i class="fa fa-gift"></i>
                  <h3 class="box-title">Pegawai Yang Ulang Tahun Bulan Ini</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <dl>
                    <dt>26 Oktober</dt>
                    <dd>Brenda Cinthya Ravenska | Kepegawaian | Analis Kepegawaian.</dd>
                    <dt>16 Oktober</dt>
                    <dd>M Ridwan Al Fahri | Kepegawaian | Analis Kepegawaian.</dd>
                    <dd>Donec id elit non mi porta gravida at eget metus.</dd>
                    <dt>20 Oktober</dt>
                    <dd>Alif Alda Bahagia Dimitri | Kepegawaian | Analis Kepegawaian.</dd>
                  </dl>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- ./col -->
			
			<div class="col-md-3">
              <div class="box box-solid">
                <div class="box-header with-border">
                  <i class="fa fa-fighter-jet"></i>
                  <h3 class="box-title">Hari Libur Bulan Ini</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <dl>
                    <dt>26 Oktober</dt>
                    <dd>Brenda Cinthya Ravenska | Kepegawaian | Analis Kepegawaian.</dd>
                    <dt>16 Oktober</dt>
                    <dd>M Ridwan Al Fahri | Kepegawaian | Analis Kepegawaian.</dd>
                    <dd>Donec id elit non mi porta gravida at eget metus.</dd>
                    <dt>20 Oktober</dt>
                    <dd>Alif Alda Bahagia Dimitri | Kepegawaian | Analis Kepegawaian.</dd>
                  </dl>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- ./col -->
			
			<div class="col-md-3">
              <div class="box box-solid">
                <div class="box-header with-border">
                  <i class="fa fa-tags"></i>
                  <h3 class="box-title">Pengumuman</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <dl>
                    <dt>26 Oktober</dt>
                    <dd>Brenda Cinthya Ravenska | Kepegawaian | Analis Kepegawaian.</dd>
                    <dt>16 Oktober</dt>
                    <dd>M Ridwan Al Fahri | Kepegawaian | Analis Kepegawaian.</dd>
                    <dd>Donec id elit non mi porta gravida at eget metus.</dd>
                    <dt>20 Oktober</dt>
                    <dd>Alif Alda Bahagia Dimitri | Kepegawaian | Analis Kepegawaian.</dd>
                  </dl>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- ./col -->
			
			
			
          </div><!-- /.row -->
		  
		  
		  <div class="row">
		  
		  <div class="col-md-12">
              <!-- LINE CHART -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Grafik Line Alpa</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <div class="box-body chart-responsive">
                  <div class="chart" id="line-chart" style="height: 300px;"></div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
			  
		  </div>
		  
		  </div>
		  
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
	  	

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url(); ?>asset/plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?php echo base_url(); ?>asset/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url(); ?>asset/plugins/fastclick/fastclick.min.js" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>asset/dist/js/app.min.js" type="text/javascript"></script>
    <!-- Sparkline -->
    <script src="<?php echo base_url(); ?>asset/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
    <!-- jvectormap -->
    <script src="<?php echo base_url(); ?>asset/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>asset/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="<?php echo base_url(); ?>asset/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    
	<!-- ChartJS 1.0.1 -->
    <script src="<?php echo base_url(); ?>asset/plugins/chartjs/Chart.min.js" type="text/javascript"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="<?php echo base_url(); ?>asset/dist/js/pages/dashboard2.js" type="text/javascript"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url(); ?>asset/dist/js/demo.js" type="text/javascript"></script>  
	
	<!-- fullCalendar 2.2.5 -->
    <script src="<?php echo base_url(); ?>asset/plugins/fullcalendar/moment.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>asset/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
	
	<!-- fullCalendar 2.2.5-->    
	<!-- <link href="<?php echo base_url(); ?>plugins/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css" />-->  
	<link href="<?php echo base_url(); ?>asset/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>asset/plugins/fullcalendar/fullcalendar.print.css" rel="stylesheet" type="text/css" media="print" />
	
	<!-- Morris.js charts -->
    <script src="<?php echo base_url(); ?>asset/plugins/morris/raphael-min.js"></script>
    <script src="<?php echo base_url(); ?>asset/plugins/morris/morris.min.js" type="text/javascript"></script>
	<!-- Morris charts -->
    <link href="<?php echo base_url(); ?>asset/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
	
	<script type="text/javascript">
      $(function () {

        /* initialize the external events
         -----------------------------------------------------------------*/
        function ini_events(ele) {
          ele.each(function () {

            // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
            // it doesn't need to have a start or end
            var eventObject = {
              title: $.trim($(this).text()) // use the element's text as the event title
            };

            // store the Event Object in the DOM element so we can get to it later
            $(this).data('eventObject', eventObject);

            // make the event draggable using jQuery UI
            $(this).draggable({
              zIndex: 1070,
              revert: true, // will cause the event to go back to its
              revertDuration: 0  //  original position after the drag
            });

          });
        }
        ini_events($('#external-events div.external-event'));

        /* initialize the calendar
         -----------------------------------------------------------------*/
        //Date for the calendar events (dummy data)
        var date = new Date();
        var d = date.getDate(),
                m = date.getMonth(),
                y = date.getFullYear();
        $('#calendar').fullCalendar({
          header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
          },
          buttonText: {
            today: 'today',
            month: 'month',
            week: 'week',
            day: 'day'
          },
		  
		  // load data dari database
		  
		  events:{
				url: '<?php echo site_url(); ?>/beranda/getEvents',
				error: function() {
					$('#script-warning').show();
				}
			},
		  
          //Random default events
		  
		  /*
          events:[
            {
              title: 'All Day Event',
              start: new Date(y, m, 1),
              backgroundColor: "#f56954", //red
              borderColor: "#f56954" //red
            },
            {
              title: 'Long Event',
              start: new Date(y, m, d - 5),
              end: new Date(y, m, d - 2),
              backgroundColor: "#f39c12", //yellow
              borderColor: "#f39c12" //yellow
            },
            {
              title: 'Meeting',
              start: new Date(y, m, d, 10, 30),
              allDay: false,
              backgroundColor: "#0073b7", //Blue
              borderColor: "#0073b7" //Blue
            },
            {
              title: 'Lunch',
              start: new Date(y, m, d, 12, 0),
              end: new Date(y, m, d, 14, 0),
              allDay: false,
              backgroundColor: "#00c0ef", //Info (aqua)
              borderColor: "#00c0ef" //Info (aqua)
            },
            {
              title: 'Birthday Party',
              start: new Date(y, m, d + 1, 19, 0),
              end: new Date(y, m, d + 1, 22, 30),
              allDay: false,
              backgroundColor: "#00a65a", //Success (green)
              borderColor: "#00a65a" //Success (green)
            },
            {
              title: 'Click for Google',
              start: new Date(y, m, 28),
              end: new Date(y, m, 29),
              url: 'http://google.com/',
              backgroundColor: "#3c8dbc", //Primary (light-blue)
              borderColor: "#3c8dbc" //Primary (light-blue)
            }
          ],
		  */
		  
          editable: true,
          droppable: true, // this allows things to be dropped onto the calendar !!!
          drop: function (date, allDay) { // this function is called when something is dropped

            // retrieve the dropped element's stored Event Object
            var originalEventObject = $(this).data('eventObject');

            // we need to copy it, so that multiple events don't have a reference to the same object
            var copiedEventObject = $.extend({}, originalEventObject);

            // assign it the date that was reported
            copiedEventObject.start = date;
            copiedEventObject.allDay = allDay;
            copiedEventObject.backgroundColor = $(this).css("background-color");
            copiedEventObject.borderColor = $(this).css("border-color");

            // render the event on the calendar
            // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
            $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

            // is the "remove after drop" checkbox checked?
            if ($('#drop-remove').is(':checked')) {
              // if so, remove the element from the "Draggable Events" list
              $(this).remove();
            }

          }
        });

        /* ADDING EVENTS */
        var currColor = "#3c8dbc"; //Red by default
        //Color chooser button
        var colorChooser = $("#color-chooser-btn");
        $("#color-chooser > li > a").click(function (e) {
          e.preventDefault();
          //Save color
          currColor = $(this).css("color");
          //Add color effect to button
          $('#add-new-event').css({"background-color": currColor, "border-color": currColor});
        });
        $("#add-new-event").click(function (e) {
          e.preventDefault();
          //Get value and make sure it is not null
          var val = $("#new-event").val();
          if (val.length == 0) {
            return;
          }

          //Create events
          var event = $("<div />");
          event.css({"background-color": currColor, "border-color": currColor, "color": "#fff"}).addClass("external-event");
          event.html(val);
          $('#external-events').prepend(event);

          //Add draggable funtionality
          ini_events(event);

          //Remove event from text input
          $("#new-event").val("");
        });
      });
    </script>
	
	<script type="text/javascript">
      $(function () {
        "use strict";

        // LINE CHART
        var line = new Morris.Line({
          element: 'line-chart',
          resize: true,
          data: [
		  
		  /*
            {y: 'Januari Q1', item1: 2666},
            {y: 'Februari Q2', item1: 2778},
            {y: 'Maret Q3', item1: 4912},
            {y: 'April Q4', item1: 3767},
            {y: 'Mei Q1', item1: 6810},
            {y: 'Juni Q2', item1: 5670},
            {y: 'Juli Q3', item1: 4820},
            {y: 'Agustus Q4', item1: 15073},
			{y: 'September Q1', item1: 15073},
            {y: 'Oktober Q2', item1: 10687},
            {y: 'November Q3', item1: 8432},
			{y: 'Desember Q4', item1: 8432}
			*/
			
			{y: '2011 Q1', item1: 2666},
            {y: '2011 Q2', item1: 2778},
            {y: '2011 Q3', item1: 4912},
            {y: '2011 Q4', item1: 3767},
            {y: '2012 Q1', item1: 6810},
            {y: '2012 Q2', item1: 5670},
            {y: '2012 Q3', item1: 4820},
            {y: '2012 Q4', item1: 15073},
            {y: '2013 Q1', item1: 10687},
            {y: '2013 Q2', item1: 8432}
			
          ],
          xkey: 'y',
          ykeys: ['item1'],
          labels: ['Item 1'],
          lineColors: ['#3c8dbc'],
          hideHover: 'auto'
        });
		
      });
    </script>