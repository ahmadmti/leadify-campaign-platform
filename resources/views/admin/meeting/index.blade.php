<html>
    <head>
        <title>Appointment Meeting Call</title>
        <meta charset="UTF-8" />
        <meta name="description" content="Free Web tutorials" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
       <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/57401d7284.js" crossorigin="anonymous"></script>
        <style>
            .schedule__meeting{
                display: none;
            }
            .loader .spinner-grow{
                width: 6rem;
                height: 6rem;
            }
            .loader{
                width: 100%;
                height: 100vh;
                display: flex;
                justify-content: center;
                align-items:center;
            }
            .loader__box{
                display: flex;
                justify-items: center;
                align-items: center;
                flex-direction: column;
            }
            .xl__box .video__stream__player {
                width: 100%;
                height: 85vh;
                /* object-fit: cover; */
                background: black;
             }
        
        .xl__wrapper {
            position: relative;
        }
        
        .sm__wrapper {
            position: absolute;
            bottom: 0;
            right: 0;
        }
        
        .xl__wrapper,
        .xl__box,
        .player_controller_box,
        .player__controlls_wrapper {
            width: 100%;
        }
        
        .player_controller_box {
            height: 13vh;
            margin: 0 auto;
            width: 80%;
            /* background-color: red; */
            display: flex;
            justify-content: space-around;
            align-items: center;
        }
        
        .controller__icon {
            font-size: 1.7rem;
            /* padding: 13px 26px; */
            width: 65px;
            height: 60px;
            border: 1px solid #eee;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            box-shadow: 1px 1px 20px 3px #eee;
        }
        
        .controller__icon:hover {
            background-color: #eee;
            cursor: pointer;
        }
        
        .call__close_controll_phone_icon {
            color: red;
            transform: rotateZ(138deg);
        }
        
        .sm_player {
            width: 340px;
        }
        
        .sm__box {
            border: 2px solid #eee;
            border-bottom: none;
            box-shadow: -5px -5px 20px 0px #eee;
        }
        .sm__box video{
            width: 340px;
        }
        #meeting__code {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .meeting__room__wrapper{
            display: none;
        }
        .meeting__box {
            display: flex;
            flex-direction: column;
        }
        
        .meeting__box input {
            margin: 10px 0;
        }
        .schedule__box,.meeting__end_content{
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        </style>
    </head>
    <body>
       <div class="loader">
          <div class="loader__box">
             <div class="spinner-grow text-primary" role="status">
                <span class="sr-only">Loading...</span>
             </div>
             <h4 class="text-center text-primary">Initializing Meeting....</h4>
          </div>     
       </div>
       {{-- loader --}}

       {{-- meeting room --}}
       <div class="meeting__room__wrapper">
            <div class="meeting__room__box">
                  <div id="video__block">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="xl__wrapper">
                                <div class="xl__box">
                                    <video ondblclick="doSwap()" poster="http://doc-le-guide-sante.com/assets/uploads/companies/leadify.png" class="video__stream__player" id="remote-video" autoplay />
                                </div>
                                <div class="sm__wrapper">
                                    <div class="sm__box">
                                        <video ondblclick="doSwap()"  class="video__stream__player sm_player" id="local-video" autoplay />
                                    </div>
                                </div>
                            </div>
                            <!-- Control Bar  -->
                            <div class="player__controlls_wrapper">
                                <div class="player_controller_box">
                                    <div class="mic_controll">
                                        <div class="controller__icon " onclick="audio()">
                                            <i class="fas fa-microphone"></i>
                                        </div>
                                    </div>
                                    <div class="call__close_controll">
                                        <div class="controller__icon overlay__round" onclick="closecall()">
                                            <i class="fas fa-phone-alt call__close_controll_phone_icon"></i>
                                        </div>
                                    </div>
                                    <div class="video__controll">
                                        <div class="controller__icon  overlay__round" onclick="videoToggle()">
                                            <i class="fas fa-video"></i>
                                        </div>
                                    </div>
                                    <div class="screen_swtich__controll overlay__round">
                                        <div class="controller__icon" onclick="screenShare()">
                                            <i class="fas fa-desktop"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Control Bar end -->

                        </div>
                    </div>
                   </div>
            </div>
       </div>
       {{-- meeting room end --}}

       <div class="schedule__meeting ">
            <div class="schedule__box">
                <div class="schedule__content">
                    <p class="text-primary font-weight-bold">Your Meeting is Schedule on <b id="meeting_time"></b></p>
                </div>
            </div>
       </div>


       {{-- meeting end --}}

       <div class="meeting__end">
                <div class="meeting__end_content">
                    <div class="end__content">
                        <p class="text-primary font-weight-bold">Meeting  End Up</p>
                        <button onclick="joinAgain()" class="btn btn-primary">Rejoin Meeting</button>
                    </div>
                </div>
       </div>

       {{-- meeting end --}}
      <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>
     <script src="{{ asset('js/webRTC-package.js') }}"></script>
         <script>
         
                    
                   

            let current_time = moment().format('YYYY-MM-DD H:m');
           
            let code = "{{ app('request')->input('code') }}";
            let meeting_time="{{ base64_decode(app('request')->input('code')) }}";
            console.log(meeting_time,current_time);
                 function joinAgain(){
                    console.log('ff');
                        webRTC.join(code);
                    
                    }
            if(new Date(current_time) >= new Date(meeting_time)){
                // init web rtc communicationg
                console.log('meeting valid');

                webRTC.join(code);
                 let streamConfig = {
                    video: {
                        width: {
                            min: 1280
                        },
                        height: {
                            min: 720
                        }
                    },
                    audio: true,
                }

                  webRTC.localStream(function(stream) {
                    $('#video__block').css('display', 'block');
                   $('.loader').fadeOut();
                    $('.meeting__room__wrapper').fadeIn();
                    let newVid = document.getElementById('local-video');
                    newVid.srcObject = stream;
                }, streamConfig);


                 webRTC.remoteStream(function(stream, id) {

            let newVid = document.getElementById('remote-video')
            newVid.srcObject = stream;
            // newVid.id = id;
            newVid.autoplay = true;
        });

        function videoToggle() {

            webRTC._videoTrackToggle('', function(val) {
                if (val) {
                    $('.video__controll i').addClass('fa-video');
                    $('.video__controll i').removeClass('fa-video-slash');
                } else {
                    $('.video__controll i').removeClass('fa-video');

                    $('.video__controll i').addClass('fa-video-slash');
                }
            });
        }

        function closecall() {
            console.log('fd');
            webRTC.closeConnection(function() {
                $('.meeting__room__wrapper').fadeOut();
                $('.meeting__end').fadeIn();
            });
        }

        function audio() {
            webRTC._audioTrackToggle(function(val) {

                if (val) {
                    $('.mic_controll i').addClass('fa-microphone');
                    $('.mic_controll i').removeClass('fa-microphone-slash');
                } else {
                    $('.mic_controll i').removeClass('fa-microphone');

                    $('.mic_controll i').addClass('fa-microphone-slash');
                }

            });
        }

        function screenShare() {

            webRTC.screenShare(function(val) {
                console.log(val);
                $('.video__controll i').attr('disabled', true);
            });
        }

function doSwap() {
    swapElements(document.getElementById("remote-video"), document.getElementById("local-video"));
}

function swapElements(obj1, obj2) {
    // create marker element and insert it where obj1 is
    var temp = document.createElement("div");
    obj1.parentNode.insertBefore(temp, obj1);

    // move obj1 to right before obj2
    obj2.parentNode.insertBefore(obj1, obj2);

    // move obj2 to right before where obj1 used to be
    temp.parentNode.insertBefore(obj2, temp);

    // remove temporary marker node
    temp.parentNode.removeChild(temp);
}
                //end if
            }else{

                console.log('Meeting In valid');
                $('.loader').fadeOut();
                $('.schedule__meeting').fadeIn();
                $('#meeting_time').text(moment(meeting_time).format('DD-MM-YYYY hh:mm A'));
             
            }



        </script>
    </body>
</html>