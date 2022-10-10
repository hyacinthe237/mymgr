@extends('Frontend.layout.master')


@section('head')
    <title>{{ __('app.team') }}s</title>
@endsection



@section('content')
    <div class="content-title">
        <div class="row">
            <div class="col-sm-6">
                {{ __('app.team') }}
            </div>

            <div class="col-sm-6">
                <div class="content-title">
                    <a href="/teams/create" class="btn btn-primary btn-md pull-right">
                        <i class="ion-android-person-add"></i> @lang('Invite')
                    </a>
                </div>
            </div>
        </div>
    </div>

    <section class="content-body">

        <div class="blocks-team-items mt-20">
            <!--block du projet nouvellement creer -->
            <div class="row">
                <div class="col-sm-3">
                    <div class="block-team-item">
                        <div class="team-image text-center">
                            <a href="#" class="circle">
                                <img src="assets/images/default-user.png" width="200px">
                            </a>
                        </div>
                        <div class="team-name text-center">
                            <span>Hyacinthe ABANDA</span>
                        </div>
                        <div class="team-function text-center">
                            <span>Developpeur</span>
                        </div>
                        <div class="team-share text-center">
                            <a href="" class="btn btn-round btn-primary">
                                <i class="ion-android-arrow-forward"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="block-team-item">
                        <div class="team-image text-center">
                            <a href="#" class="circle">
                                <img src="assets/images/default-user.png" width="200px">
                            </a>
                        </div>
                        <div class="team-name text-center">
                            <span>Max Emmanuel TONYE</span>
                        </div>
                        <div class="team-function text-center">
                            <span>Manager</span>
                        </div>
                        <div class="team-share text-center">
                            <a href="" class="btn btn-round btn-primary">
                                <i class="ion-android-arrow-forward"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="block-team-item">
                        <div class="team-image text-center">
                            <a href="#" class="circle">
                                <img src="assets/images/default-user.png" width="200px">
                            </a>
                        </div>
                        <div class="team-name text-center">
                            <span>Ulrich NTELLA</span>
                        </div>
                        <div class="team-function text-center">
                            <span>Developpeur</span>
                        </div>
                        <div class="team-share text-center">
                            <a href="" class="btn btn-round btn-primary">
                                <i class="ion-android-arrow-forward"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </section>

@endsection
