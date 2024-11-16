@include('frontend.dashboard.header')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" >

@php
    $id = Auth::user()->id;
    $profileData = App\Models\User::find($id);
@endphp

<section class="section pt-4 pb-4 osahan-account-page">
    <div class="container">
       <div class="row">
          
        @include('frontend.dashboard.sidebar')


<div class="col-md-9">
   
    
            <h4 style="font-weight: 15px;" >User Profile </h4>
            
            
    <div class="card" style="box-shadow: 2px 2px 2px 2px; justify-content: space-between; box-sizing: border-box">
    
        
           
  <form action="{{route('user.profile.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                
            <div class="row">
                <div class="col-lg-6">
                    <div>
                        <div class="mb-3 mr-5 ml-5 mt-3">
                            <label for="example-text-input" class="form-label">Name</label>
                            <input class="form-control" type="text" name="name" value="{{ $profileData->name }}" id="example-text-input">
                        </div>
            
                        <div class="mb-3 mr-5 ml-5 mt-3" >
                            <label for="example-text-input" class="form-label">Email</label>
                            <input class="form-control" name="email" type="email" value="{{ $profileData->email }}" id="example-text-input">
                        </div>
            
                        <div class="mb-3 mr-5 ml-5 mt-3">
                            <label for="example-text-input" class="form-label">Phone</label>
                            <input class="form-control" name="phone" type="text" value="{{ $profileData->phone }}" id="example-text-input">
                        </div>
                          
                    </div>
                </div>
            
                <div class="col-lg-6">
                    <div class="mb-3 mr-5 ml-5 mt-3">
                        <div class="mb-3">
                            <label for="example-text-input" style="" class="form-label">Address</label>
                            <input class="form-control" name="address" style="" type="text" value="{{ $profileData->address }}" id="example-text-input">
                        </div>
            
                        <div class="mb-3">
                            <label for="example-text-input" class="form-label">Profile Image</label>
                            <input class="form-control" name="photo" type="file"  id="image">
                        </div>
                        <div class="mb-3">
                             
                            <img id="showImage" src="{{ (!empty($profileData->photo)) ? url('upload/user_images/'.$profileData->photo) : url('upload/no-image/no_image.jpg') }}" alt="" class="rounded-circle p-1 bg-primary" width="110">
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Save Changes</button>
                        </div>
                          
                    </div>
                </div>
           
            </form>
        
        </div>
    
        
        
        
        
    </div>
    </div>
</div>
       </div>
    </div>
 </section>

 <script type="text/javascript">
    $(document).ready(function(){
        $('#image').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src',e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        })
    })
</script>
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