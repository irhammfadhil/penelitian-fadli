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
                <form action="/login" method="post" enctype="multipart/form-data">
                    @csrf
                    <!-- Email input -->
                    <div class="form-outline mb-4">
                        <label class="form-label" for="form3Example3">Nama (*)</label>
                        <input type="text" id="form3Example3" class="form-control form-control-lg"
                        placeholder="Nama" required/>
                    </div>
                    <div class="form-outline mb-4">
                        <label class="form-label" for="form3Example3">Nama Pengguna (*)</label>
                        <input type="text" id="form3Example3" class="form-control form-control-lg"
                        placeholder="Nama Pengguna" required/>
                    </div>
                    <div class="form-outline mb-4">
                        <label class="form-label" for="form3Example3">Alamat email (opsional)</label>
                        <input type="email" id="form3Example3" class="form-control form-control-lg"
                        placeholder="Alamat email (opsional)" />
                    </div>
                    <!-- Password input -->
                    <div class="form-outline mb-3">
                        <label class="form-label" for="form3Example3">Password (*)</label>
                        <input type="password" id="form3Example4" class="form-control form-control-lg"
                        placeholder="Password" required/>
                    </div>
                    <div class="form-outline mb-3">
                        <label class="form-label" for="form3Example3">Masukkan kembali password Anda (*)</label>
                        <input type="password" id="form3Example4" class="form-control form-control-lg"
                        placeholder="Masukkan kembali password Anda" required/>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary block"
                        style="padding-left: 2.5rem; padding-right: 2.5rem; text-align: center;">Login</button>

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
    </section>

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