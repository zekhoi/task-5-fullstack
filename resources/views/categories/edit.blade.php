@extends('layouts.app')

@section('content')
    <div class="pagetitle">
        <h1>Edit Category</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/home">Home</a></li>
                <li class="breadcrumb-item"><a href="/categories">Categories</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        @if (session()->has('alert'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('alert') }} <button type="button" class="btn-close"
                                    data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <h5 class="card-title">Details</h5>

                        <!-- General Form Elements -->
                        <form action="/categories/{{ $category->id }}" method="POST">
                            @method('put')
                            @csrf
                            <div class="row mb-3">
                                <label for="yourCategory" class="col-sm-2 form-label">Category name</label>
                                <div class="col-sm-10">
                                    <input type="text" name="name"
                                        class="form-control @error('category') is-invalid @enderror" id="yourCategory"
                                        required value="{{ old('category', $category->name) }}">
                                    @error('category')
                                        <div class="invalid-feedback">Please enter your category name.</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form><!-- End General Form Elements -->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection