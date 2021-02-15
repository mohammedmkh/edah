<div class="mailMessage">
    @if(Request::is('changeOrderStatus') || Request::is('api/user/createOrder') || Request::is('reset_password') || Request::is('api/user/verifyPhone') || Request::is('api/user/verifyPhone') || Request::is('api/driver/verifyPhone') || Request::is('api/driver/resendOTP')  || Request::is('api/user/forgetPassword')|| Request::is('api/driver/forgetPassword') )      
        {!!$content!!}  
    @endif        
</div>   
