<!DOCTYPE html>
<html lang="en">

@include('layouts.header')

<body>

  @include('layouts.navbar')

  <!-- ======= Hero Section ======= -->

  <main id="main">
    <!-- ======= Team Section ======= -->
    <section class="vh-100">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-9 col-lg-6 col-xl-5">
                <img src="{{asset('Picture1.png')}}"
                class="img-fluid" alt="Sample image">
            </div>
            <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                <h1 class="text-center">Daftar</h1>
                @if($message = Session::get('danger'))
                            <div class="alert alert-danger" role="alert">
                                <strong>{{$message}}</strong>
                            </div>
                            @elseif($message = Session::get('success'))
                            <div class="alert alert-success" role="alert">
                                <strong>{{$message}}</strong>
                            </div>
                            @elseif($message = Session::get('registered'))
                            <div class="alert alert-danger" role="alert">
                                <strong>Pengguna sudah terdaftar. Lupa password? <a href="/forgot-password">Klik di sini untuk mereset password Anda.</a></strong>
                            </div>
                @endif
                <form action="/register" method="post" enctype="multipart/form-data">
                    @csrf
                    <!-- Email input -->
                    <div class="form-outline mb-4">
                        <label class="form-label" for="form3Example3">Nama (*)</label>
                        <input type="text" id="name" name="name" class="form-control form-control-lg"
                        placeholder="Nama" required/>
                    </div>
                    <div class="form-outline mb-4">
                        <label class="form-label" for="form3Example3">Nama Pengguna (*)</label>
                        <input type="text" id="form3Example3" name="username" class="form-control form-control-lg"
                        placeholder="Nama Pengguna" required/>
                    </div>
                    <div class="form-outline mb-4">
                        <label class="form-label" for="form3Example3">Alamat email (opsional)</label>
                        <input type="email" id="form3Example3" name="email" class="form-control form-control-lg"
                        placeholder="Alamat email (opsional)"/>
                    </div>
                    <!-- Password input -->
                    <div class="form-outline mb-3">
                        <label class="form-label" for="form3Example3">Password (*)</label>
                        <input type="password" id="form3Example4" name="password" class="form-control form-control-lg"
                        placeholder="Password" required/>
                        <small>Panjang minimum password adalah 8 karakter.</small>
                    </div>
                    <div class="form-outline mb-3">
                        <label class="form-label" for="form3Example3">Masukkan kembali password Anda (*)</label>
                        <input type="password" id="form3Example4" name="confirm_password" class="form-control form-control-lg"
                        placeholder="Masukkan kembali password Anda" required/>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary block"
                        style="padding-left: 2.5rem; padding-right: 2.5rem; text-align: center;">Daftar</button>

                    <div class="text-center text-lg-start mt-4 pt-2">
                        <p class="small fw-bold mt-2 pt-1 mb-0 text-center">Sudah mempunyai akun? <a href="/login"
                            class="link-danger">Login.</a></p>
                        <p class="small fw-bold mt-2 pt-1 mb-0 text-center"><a href="/forget-password"
                            class="link-danger">Lupa Password?</a></p>
                    </div>
                </form>
            </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>    
    </section>
    <!-- Modal -->
    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Informed Consent Layanan Simetri</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            Saya yang bertandatangan di bawah ini, 
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Saya Tidak Setuju</button>
            <button type="button" class="btn btn-primary">Saya Setuju</button>
        </div>
        </div>
    </div>
    </div>

  </main><!-- End #main -->

  @include('layouts.footer')

  <style>
        .divider:after,
        .divider:before {
        content: "";
        flex: 1;
        height: 1px;
        background: #eee;
        }
        .h-custom {
        height: calc(100% - 73px);
        }
        @media (max-width: 450px) {
        .h-custom {
        height: 100%;
        }
        }
        .block {
            display: block;
            width: 100%;
            border: none;
            background-color: #1D443F;
            padding: 14px 28px;
            font-size: 16px;
            cursor: pointer;
            text-align: center;
        }
  </style>
</body>

</html>