@include('frontend.dashboard.header')

@php
$id=Auth::user()->id;
$profileData=App\Models\User::find($id)
@endphp

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" >
 
    <div class="row"> 
     @include('frontend.dashboard.sidebar')
       <div class="col-lg-6">
            <form action="{{route('change.password.submit')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card mt-3">
               
                    <div class="col-lg-12">
                   
                        <div class="mb-3 mr-5 ml-5 mt-3">
                            <label for="example-text-input" class="form-label">Old Password</label>
                            <input class="form-control @error('old_password') is-invalid @enderror" type="password" name="old_password"  id="example-text-input">
                             @error('old_password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
            
                        <div class="mb-3 mr-5 ml-5 mt-3" >
                            <label for="example-text-input" class="form-label">New Password</label>
                            <input class="form-control @error('password') is-invalid @enderror" name="password" type="password"  id="example-text-input">
                             @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
            
                        <div class="mb-3 mr-5 ml-5 mt-3">
                            <label for="example-text-input" class="form-label">Confirm New Password</label>
                            <input class="form-control @error('password-confirmation') is-invalid @enderror" name="password-confirmation" type="password" value="" id="example-text-input">
                        </div>
                          

                         <div class="mb-3 mr-5 ml-5 mt-3">
                           
                            <button type="submit" class="btn btn-danger waves-effect waves-light" >Save Changes</button>
                        </div> 
            
                    </div>
                </div>
             </form>       
        </div>
           
   
</div>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
 @if(Session::has('message'))
 var type = "{{ Session::get('alert-type','info') }}"
 switch(type){
    case 'info':
    toastr.info(" {{ Session::get('message') }} ");
    break;
    case 'success':
    toastr.success(" {{ Session::get('message') }} ");
    break;
    case 'warning':
    toastr.warning(" {{ Session::get('message') }} ");
    break;
    case 'error':
    toastr.error(" {{ Session::get('message') }} ");
    break; 
 }
 @endif 
</script>
        
@include('frontend.dashboard.footer')

