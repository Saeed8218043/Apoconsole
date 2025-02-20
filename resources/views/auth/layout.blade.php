@extends('base.base')

@section('content')
    <div class="d-flex flex-column flex-root">
        <!--begin::Authentication-->
        <div class="d-flex h-100">

            {{-- <div class="login-half half-x"> --}}
                <!--begin::Content-->
                <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">


                    <!--begin::Wrapper-->
                    <div class="login-form-panel bg-body rounded shadow-lg p-5 p-lg-15 mx-auto">
                        <!--begin::Logo-->
                        <a href="{{ route('home') }}" class="mb-8 mx-auto d-block text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="-180 0 600 200"><defs><style>.cls-1{fill:#161938;}.cls-2{fill:url(#linear-gradient);}</style><linearGradient id="linear-gradient" x1="176.41" y1="128.01" x2="66.33" y2="17.93" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#f51d82"/><stop offset="0.26" stop-color="#b51fe2"/><stop offset="0.72" stop-color="#4797ec"/><stop offset="0.82" stop-color="#30b6eb"/><stop offset="0.94" stop-color="#19d4ea"/><stop offset="1" stop-color="#10e0ea"/></linearGradient></defs><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><path class="cls-1" d="M40.12,148.6h4.81v11q0,4.23-2.5,6.42t-7.15,2.18q-4.59,0-7.12-2.21a8,8,0,0,1-2.54-6.36v-11h4.82v11.1a4.19,4.19,0,0,0,1.32,3.24,4.92,4.92,0,0,0,3.47,1.21,5,5,0,0,0,3.56-1.24,4.6,4.6,0,0,0,1.33-3.54Z"/><path class="cls-1" d="M59.13,148.6l8.58,19.31H62.54L61,164.1H52.3l-1.44,3.81h-5.1l7.8-19.31Zm.41,12.12-3.13-7.5-2.84,7.5Z"/><path class="cls-1" d="M89.5,148.6v19.31H85.43L74.77,155.54v12.37H70V148.6h4.41l10.31,11.81V148.6Z"/><path class="cls-1" d="M111.27,148.6v3.54h-7v15.77H99.46V152.14h-7V148.6Z"/><path class="cls-1" d="M128.52,148.6h4.81v11a8.1,8.1,0,0,1-2.5,6.42q-2.51,2.18-7.15,2.18T116.55,166a8,8,0,0,1-2.53-6.36v-11h4.82v11.1a4.19,4.19,0,0,0,1.32,3.24,4.92,4.92,0,0,0,3.46,1.21,5,5,0,0,0,3.56-1.24,4.61,4.61,0,0,0,1.34-3.54Z"/><path class="cls-1" d="M147.89,155.76l6.21-7.16h4.18v19.31h-4.81v-12l-5.22,6h-.72l-5.22-6v12H137.5V148.6h4.18Z"/><path class="cls-1" d="M23.45,163.88v4.28H11.07C5,168.16,0,163.73,0,158.26s5-9.91,11.07-9.91,11.07,4.44,11.07,9.91a8.92,8.92,0,0,1-.87,3.83H16a5.16,5.16,0,0,0,1.83-3.83c0-3.1-3-5.62-6.78-5.62s-6.79,2.52-6.79,5.62,2.8,5.41,6.34,5.6v0Z"/><path class="cls-1" d="M188,164.37v3.54H173.73V148.6h14v3.54h-9.23v4.05h8.8v3.54h-8.8v4.64Z"/><path class="cls-1" d="M191.64,148.6h8.63a6.46,6.46,0,0,1,4.56,1.62,5.19,5.19,0,0,1,1.76,3.93q0,3.19-3.32,4.73,1.46.66,2.76,3.56t2.53,5.47h-5.28c-.31-.63-.86-1.85-1.64-3.63a11.38,11.38,0,0,0-2-3.44,2.64,2.64,0,0,0-1.79-.77h-1.39v7.84h-4.81Zm4.81,3.54v4.4H199a3,3,0,0,0,1.93-.58,2,2,0,0,0,.71-1.64c0-1.45-.92-2.18-2.75-2.18Z"/><path class="cls-1" d="M211,148.6h8.62a6.35,6.35,0,0,1,4.65,1.7,5.45,5.45,0,0,1,1.73,4,5.64,5.64,0,0,1-1.7,4.12,6.26,6.26,0,0,1-4.66,1.72h-3.82v7.75H211Zm4.82,3.54v4.48H218c2,0,3-.75,3-2.24a1.87,1.87,0,0,0-.8-1.75,5.48,5.48,0,0,0-2.73-.49Z"/><path class="cls-1" d="M170,12a2.93,2.93,0,0,1,1.16.64c1.26,1.41,1.51,8.66-5.76,22-7.9,14.57-21.47,30.82-38.21,45.78-33.56,30-62.3,39.65-71.16,36.74a2.87,2.87,0,0,1-1.16-.64c-1.26-1.41-1.51-8.66,5.76-22,7.9-14.57,21.47-30.82,38.2-45.78C132.38,18.74,161.12,9.07,170,12m3.25-9.89C157.43-3.1,123.68,12.54,91.88,41,55.47,73.5,35.42,110.45,47.08,123.5a12.85,12.85,0,0,0,5.67,3.59c15.81,5.2,49.56-10.44,81.36-38.87,36.4-32.53,56.46-69.48,44.8-82.53a12.83,12.83,0,0,0-5.68-3.59Z"/><path class="cls-2" d="M113,114.5a49.93,49.93,0,1,1,23.41-5.84h23.8A64.58,64.58,0,1,0,113,129.19h64.6V114.5Z"/><path class="cls-1" d="M178.9,5.69a12.76,12.76,0,0,0-5.66-3.59C157.43-3.1,123.68,12.55,91.87,41,55.47,73.5,35.42,110.45,47.08,123.5a12.83,12.83,0,0,0,5.68,3.59c5.75,1.9,13.87,1,23.41-2.21L65.92,117c-4.36.92-7.73,1-9.91.25a2.87,2.87,0,0,1-1.16-.64c-1.26-1.41-1.51-8.66,5.76-22.06,7.9-14.56,21.47-30.82,38.2-45.77C132.38,18.74,161.12,9.07,170,12a2.82,2.82,0,0,1,1.16.64c.91,1,1.3,5.08-1.3,12.3l9,5.71C183.17,19.75,183.52,10.85,178.9,5.69Z"/></g></g></svg>
                        </a>
                        <!--end::Logo-->
                        {{ $slot }}
                    </div>
                    <!--end::Wrapper-->
                </div>
            {{-- </div> --}}
            {{-- <div class="login-half half-y">
                <img src="{{ asset('quantum/images/Asset 2.png') }}" alt="Illustration" class="img-fluid" />
            </div> --}}


            <!--end::Content-->
        </div>
        <!--end::Authentication-->
    </div>
@endsection
