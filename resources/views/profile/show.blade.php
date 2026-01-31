@extends('layouts.default')

@section('content')
<div class="container-fluid my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h2 class="mb-0 fw-bold">Profil Saya</h2>
                </div>

                <div class="card-body">

                    {{-- Avatar --}}
                    <div class="d-flex align-items-center gap-4 mb-4">
                        {{-- <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center"
                             style="width:80px;height:80px;font-size:32px;font-weight:bold; margin-right: 10px;">
                              {{ strtoupper(substr(auth()->user()->nama, 0, 1)) }}
                        </div> --}}

                        <div>
                            <h3 class="mb-1 fw-semibold">
                                {{ auth()->user()->nama }}
                            </h3>
                            <small class="text-muted">
                                {{ auth()->user()->email }}
                            </small>
                        </div>
                    </div>

                    <hr>

                    {{-- Detail --}}
                    <div class="row g-4">
                        <div class="col-md-6">
                            <small class="text-muted fw-bold">Nama Lengkap</small>
                            <div class="fw-semibold">
                                {{ auth()->user()->nama }}
                            </div>
                        </div>

                        <div class="col-md-6 mt-2">
                            <small class="text-muted fw-bold">Email</small>
                            <div class="fw-semibold">
                                {{ auth()->user()->email }}
                            </div>
                        </div>

                        <div class="col-md-6 mt-2">
                            <small class="text-muted fw-bold">No. HP</small>
                            <div class="fw-semibold">
                                {{ auth()->user()->no_hp ?? '-' }}
                            </div>
                        </div>

                        {{-- <div class="col-md-6 mt-2">
                            <small class="text-muted">Role</small>
                            <div class="fw-semibold text-capitalize">
                                {{ auth()->user()->role ?? 'user' }}
                            </div>
                        </div> --}}

                        <div class="col-md-6 mt-2">
                            <small class="text-muted fw-bold">Alamat</small>
                            <div class="fw-semibold">
                                {{ auth()->user()->alamat ?? '-' }}
                            </div>
                        </div>
                    </div>

                    {{-- Action --}}
                    <div class="mt-4 text-end">
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                            Edit Profile
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection