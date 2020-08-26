    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- CSS here -->
    {!! Html::style('resources/assets/css/bootstrap.min.css') !!}
    {!! Html::style('resources/assets/css/owl.carousel.min.css') !!}
    {!! Html::style('resources/assets/css/magnific-popup.css') !!}
    {!! Html::style('resources/assets/css/font-awesome.min.css') !!}
    {!! Html::style('resources/assets/css/themify-icons.css') !!}
    {!! Html::style('resources/assets/css/nice-select.css') !!}
    {!! Html::style('resources/assets/css/flaticon.css') !!}
    {!! Html::style('resources/assets/css/gijgo.css') !!}
    {!! Html::style('resources/assets/css/animate.css') !!}
    {!! Html::style('resources/assets/css/slicknav.css') !!}
    {!! Html::style('resources/assets/css/style.css') !!}
    <!-- <link rel="stylesheet" href="css/responsive.css"> -->
    <style type="text/css">
        .error{
            color: red;
        }
        select{
            display: block !important;
            width: 100%;
            height: 50px;
            margin-bottom: 30px;
            color: #000;
            padding: 10px;
            border: 1px solid #ddd;
        }
        /*#shop-select{
            display: block !important;
            width: 100%;
            height: 50px;
            margin-bottom: 30px;
            color: #000;
            padding: 10px;
            border: 1px solid #ddd;
        }*/
    </style>
    <!-- form itself end-->
    @include('layouts.flash')
    <?php //print_r($queues);exit(); ?>
    <div class="service_area">
        <div class="container">
            <div class="row justify-content-center ">
                <h3 class="mb-10">{{ trans('messages.lbl_queue_details') }}</h3>
                    <table id="productSizes" class="table">
                        <thead>
                            <tr class="d-flex">
                                <th class="col-1">#</th>
                                <th class="col-3">{{ trans('messages.lnk_service') }}</th>
                                <th class="col-3">{{ trans('messages.tbl_queue_no') }}</th>
                                <th class="col-5">{{ trans('messages.tbl_queue_time') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($queues as $key => $queue)
                            @if(Auth::user()->email == $queue['email'])
                                <?php $color = 'blue;'; ?>
                            @else
                                <?php $color = 'black;'; ?>
                            @endif
                            <tr class="d-flex" style='color:{{$color}}'>
                                <td class="col-1">
                                {{ $key + 1 }}</td>
                                <td class="col-3">{{ $queue['servicename'] }}</td>
                                <td class="col-3">{{ $queue['token_number'] }}</td>
                                <td class="col-5">{{ $queue['queue_time'] }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-center" colspan="4" style="color:red;font-weight: bold;">
                                    {{ trans('messages.tbl_no_queue_data') }}
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
            </div>
        </div>
    </div>
    
    <!-- form itself end -->

        <!-- JS here -->
    {!! Html::script('resources/assets/js/vendor/modernizr-3.5.0.min.js') !!}
    {!! Html::script('resources/assets/js/vendor/jquery-1.12.4.min.js') !!}
    {!! Html::script('resources/assets/js/popper.min.js') !!}
    {!! Html::script('resources/assets/js/bootstrap.min.js') !!}
    {!! Html::script('resources/assets/js/owl.carousel.min.js') !!}
    {!! Html::script('resources/assets/js/isotope.pkgd.min.js') !!}
    {!! Html::script('resources/assets/js/ajax-form.js') !!}
    {!! Html::script('resources/assets/js/waypoints.min.js') !!}
    {!! Html::script('resources/assets/js/jquery.counterup.min.js') !!}
    {!! Html::script('resources/assets/js/imagesloaded.pkgd.min.js') !!}
    {!! Html::script('resources/assets/js/scrollIt.js') !!}
    {!! Html::script('resources/assets/js/jquery.scrollUp.min.js') !!}
    {!! Html::script('resources/assets/js/wow.min.js') !!}
    
    
    {!! Html::script('resources/assets/js/jquery.slicknav.min.js') !!}
    {!! Html::script('resources/assets/js/jquery.slicknav.min.js') !!}
    {!! Html::script('resources/assets/js/jquery.magnific-popup.min.js') !!}
    {!! Html::script('resources/assets/js/plugins.js') !!}
    {!! Html::script('resources/assets/js/gijgo.min.js') !!}

    <!--contact js-->
    {!! Html::script('resources/assets/js/contact.js') !!}
    {!! Html::script('resources/assets/js/jquery.ajaxchimp.min.js') !!}
    {!! Html::script('resources/assets/js/jquery.form.js') !!}
    {!! Html::script('resources/assets/js/jquery.validate.min.js') !!}
    {!! Html::script('resources/assets/js/mail-script.js') !!}

    {!! Html::script('resources/assets/js/main.js') !!}
    
    <script>
        $('#datepicker').datepicker({
            iconsLibrary: 'fontawesome',
            disableDaysOfWeek: [0, 0],
            format: 'yyyy-mm-dd'
        //     icons: {
        //      rightIcon: '<span class="fa fa-caret-down"></span>'
        //  }
        });
        $('#datepicker2').datepicker({
            iconsLibrary: 'fontawesome',
            icons: {
             rightIcon: '<span class="fa fa-caret-down"></span>'
         }

        });
        var timepicker = $('#timepicker').timepicker({
         format: 'HH.MM'
     });
    </script>
    <script type="text/javascript">
        $.ajaxSetup({

            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }

        });

        $("#service-select").change(function(e){
            // e.preventDefault();
            var serviceid = this.value;
            var queuedate = $("input[name='queuedate']").val();
            // $("#shop-select").empty();
            $('#shop-select').find('option').not(':first').remove();
            $.ajax({

               type:'POST',

               url:'getShopsDetails',

               data:{serviceid:serviceid, queuedate:queuedate},

                dataType:'json',

               success:function(data){
                // alert(JSON.stringify(data));
                var len = data.length;
                 
                 if(len != 0){
                   
                   for(var i=0; i<len; i++){

                     var id = data[i].shopid;
                     var name = data[i].shopname;
                     var option = "<option value='"+id+"'>"+name+"</option>"; 

                     $("#shop-select").append(option);
                   }
                 }
                  
               },
               error:function(){
                // alert("DATA NOT FOUND");
               }

            });
        });

        $("#shop-select").change(function(e){
            var serviceid = $("#service-select").val();
            var shopid = $("#shop-select").val();
            var queuedate = $("input[name='queuedate']").val(); 
            // alert(queuedate);
            
            // $("#shop-select").empty();
            $('#barber-select').find('option').not(':first').remove();
            $.ajax({

               type:'POST',

               url:'getBarbersDetails',

               data:{serviceid:serviceid, shopid:shopid, queuedate:queuedate},

                dataType:'json',

               success:function(data){
                // alert(JSON.stringify(data));
                var len = data.length;
                 
                 if(len != 0){
                   
                   for(var i=0; i<len; i++){

                     var id = data[i].barberid;
                     var name = data[i].barbername;
                     var option = "<option value='"+id+"'>"+name+"</option>"; 

                     $("#barber-select").append(option);
                   }
                 }
                  
               },
               error:function(){
                // alert("DATA NOT FOUND");
               }

            });
        });

        // $("#submit").click(function(){
            // alert($("input[name='queuedate']").val()); return false;
            /*if($("input[name='queuedate']").val() == ''){
                alert("日付を選んでください。");
                $('#service-select').focus();
                return false;
            }else if($("#service-select" ).val() == null) {
                alert("サービスを選んでください。");
                $('#service-select').focus();
                return false;
            } else if($("#shop-select" ).val() == null) {
                alert("店舗を選んでください。");
                $('#shop-select').focus();
                return false;
            } else if($("#barber-select" ).val() == null) {
                alert("理髪師を選んでください。");
                $('#barber-select').focus();
                return false;
            }*/
            /*var date = $("input[name='queuedate']").val();
            var service = $("#service-select" ).val();
            var shop = $("#shop-select" ).val();
            var barber = $("#barber-select" ).val();
            var name = $("#name" ).val();
            var email = $("#mailid" ).val();

            if(date =="") {
                alert("日付を選んでください。");
                $('#queuedate').focus();
                return false;
            } else if(service == null) {
                alert("サービスを選んでください。");
                $('#service-select').focus();
                return false;
            } else if(shop == null) {
                alert("店舗を選んでください。");
                $('#shop-select').focus();
                return false;
            } else if(barber == null) {
                alert("理髪師を選んでください。");
                $('#barber-select').focus();
                return false;
            }*/
        // });

    </script>