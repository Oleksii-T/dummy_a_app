@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <div class="float-left">
                            <h1 class="m-0 text-dark">Feedback</h1>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{route('admin.feedbacks.index')}}">Feedbacks</a></li>
                            <li class="breadcrumb-item active">Feedback</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary card-outline">
                            <div class="card-body p-0">
                                <div class="mailbox-read-info">
                                    <h6>
                                        From: @if($feedback->user) <a href="{{route('admin.users.edit', $feedback->user->id)}}">User #{{$feedback->user->id}}</a> @else Guest @endif
                                        <span class="mailbox-read-time float-right">{{$feedback->created_at->format('d M Y H:i')}}</span>
                                    </h6>
                                </div>
                                <div class="mailbox-read-info">
                                    <h6>User name: {{$feedback->name}}</h6>
                                    <h6>Reply email: {{$feedback->email}}</h6>
                                </div>
                                <div class="mailbox-read-info">
                                    <p style="white-space: pre-line;">{{$feedback->content}}</p>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{route('admin.feedbacks.index')}}" type="button" class="btn btn-default">Cancel</a>
                                @if (!$feedback->is_read)
                                    <button type="button" class="btn btn-default read-feedback" data-link="{{route('admin.feedbacks.read', $feedback)}}"><i class="fas fa-check"></i> Mark as Read</button>
                                @endif
                            </div>
                          </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{asset('assets/admin/js/feedbacks.js')}}"></script>
@endpush
