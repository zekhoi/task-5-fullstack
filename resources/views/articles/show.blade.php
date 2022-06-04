@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-md-6">

                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="fw-bold fs-3">
                            {{ $article->title }}
                        </div>
                    </div>

                    @isset($article->image)
                        <img class="card-img-top" src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" />
                    @endisset

                    <div class="card-body">

                        <div class="row mb-4">
                            <div class="col-12 d-flex justify-content-between">
                                <span class="fst-italic">Author : {{ $article->user->name }}</span>
                                <span class="badge bg-success badge-pill">{{ $article->category->name }}</span>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                {{ $article->content }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 d-flex justify-content-between">
                                <span class="badge bg-info badge-pill">Created at : {{ $article->created_at }}</span>
                                <span class="badge bg-info badge-pill">Updated at : {{ $article->updated_at }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-between">
                        @can('delete', $article)
                            <form action="{{ route('articles.destroy', ['article' => $article]) }}" method="article">
                                @method('Delete')
                                @csrf

                                <button class="btn btn-danger btn-sm">
                                    Delete
                                </button>
                            </form>
                        @endcan

                        @can('update', $article)
                            <a class="btn btn-warning btn-sm" href="{{ route('articles.edit', ['article' => $article]) }}">
                                Edit
                            </a>
                        @endcan
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection