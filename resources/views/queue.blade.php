@extends('layouts.queue-app')

@section('content')
    <style type="text/css">
        #result{
            color: red !important;
            font-weight: bold;
        }
        h4{
            color: red !important;
            font-weight: bold;
        }
    </style>
     <!-- bradcam_area_start -->
     <div class="bradcam_area breadcam_bg overlay">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3>キュー管理</h3>
                </div>
            </div>
        </div>
    </div>
    <!-- bradcam_area_end -->

    <!-- ================ content section end ================= -->
    <div class="make_apppointment_area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section_title pl-68">
                        <h3>キュー管理</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-7">
                    <div class="appoint_ment_form pl-68">
                        <div class="single_appontment">
                            <h4 id="result" style="color: red;"></h4>
                        </div>
                        <div class="single_appontment">
                            <h3>Current Token</h3>
                            <table>
                            @forelse($services as $key => $service)
                            <tr class="d-flex justify-content-between">
                                <th>{{ $service->name }}&nbsp;&nbsp;&nbsp;&nbsp;:</th>
                                <td id="tokenNumber_{{ $service->id }}"></td>
                            </tr>
                            @empty
                                <tr>Please Register Service</tr>
                            @endforelse
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                @forelse($services as $key => $service)
                <div class="col-lg-3">
                    <div class="appoint_ment_form pl-78">
                        <div class="form_btn" style="background-color: #CAE1FF;">
                            <center>
                            <span id="serv_{{ $service->id }}" data-qid=""></span>
                            <br/>
                            <h3>{{ $service->name }}</h3><br/>
                            <a class="genric-btn success" 
                            href="javascript:callNext('{{ $service->id }}','{{ $service->shop_id }}')">CALL NEXT</a>
                            <br/><br/>
                            <a class="genric-btn success" 
                            href="javascript:callAgain('{{ $service->id }}')">CALL AGAIN</a><br/><br/>
                            </center>
                        </div>
                    </div>
                </div>
                @empty
                    <p>Please Register Service</p>
                @endforelse
                

            </div>
        </div>
    </div> 

    <!-- <div class="about_area ">
        <div class="container">
            <div class="row align-items-center">
                
                <div class="col-xl-6 col-lg-6 col-md-6">
                    
                </div>
            </div>
        </div>
    </div> -->
    <!-- about_area_end -->

    <script type="text/javascript">
        
        function callNext(service_id, shop_id) {
            $("#result").empty();
            $.ajaxSetup({

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }

            });

            var service_id = service_id;
            var shop_id = shop_id;
            var q_id = $("#serv"+"_"+service_id).data('qid');
            // alert(q_id);

            $.ajax({

               type:'POST',

               url:'queue/callNext',

               data:{service_id:service_id, shop_id:shop_id, q_id:q_id},

                dataType:'json',

                success:function(data){
                    // alert(JSON.stringify(data.id));
                    $("#tokenNumber"+"_"+data.service_id).html("");
                    $("#tokenNumber"+"_"+data.service_id).html("&nbsp;&nbsp;"+data.token_number);
                    $("#serv"+"_"+data.service_id).html("");
                    $("#serv"+"_"+data.service_id).data('qid', data.id);
                },
               error:function(){
                $("#result").html("キューは空白状況になっています。");
               }

            });
        }

        function callAgain(service_id){
            
            var q_id = $("#serv"+"_"+service_id).data('qid');
            if (q_id == "") {
                alert("Please First Click Call Next Button");
                return false;
            }

            $("#result").empty();
            $.ajaxSetup({

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }

            });

            $.ajax({

               type:'POST',

               url:'queue/callAgain',

               data:{q_id:q_id},

                dataType:'json',

                success:function(data){
                    // alert(JSON.stringify(data.id));
                    $("#tokenNumber"+"_"+data.service_id).html("");
                    $("#tokenNumber"+"_"+data.service_id).html("&nbsp;&nbsp;"+data.token_number);
                    $("#serv"+"_"+data.service_id).html("");
                    $("#serv"+"_"+data.service_id).data('qid', data.id);
                },
               error:function(){
                alert("error");
               }

            });
            
        }
    </script>

    
@endsection