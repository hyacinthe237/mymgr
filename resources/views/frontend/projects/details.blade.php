@extends('Frontend.layout.master')


@section('head')
    <title>{{ __('app.project') }}s</title>
@endsection



@section('content')
    <div class="content-title">
        <a href="{{ route('projects.index') }}" class="btn btn-md btn-grey pull-right">
            <i class="ion-reply"></i> @lang('Cancel')
        </a>
        {{ __('Développement d\'un logiciel de suivi des projets de recherche') }}
    </div>


    <section class="content-body pt-20">
        <div class="_block _block-radius">
            <div class="_block-content">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
                        <i class="ion-android-folder"></i> @lang('Details')
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="task-tab" data-toggle="tab" href="#task" role="tab" aria-controls="task" aria-selected="false">
                        <i class="ion-social-buffer"></i> @lang('Tasks')
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="ticket-tab" data-toggle="tab" href="#ticket" role="tab" aria-controls="ticket" aria-selected="false">
                        <i class="ion-clipboard"></i> @lang('Tickets')
                    </a>
                  </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                      <div class="details">
                          <p><b><i class="ion-information"></i>   @lang('Status')</b>: <span>@lang('Ongoing')</span></p>
                          <p><b><i class="ion-android-calendar"></i>   @lang('Start Date')</b>: <span>15/07/2017</span></p>
                          <p><b><i class="ion-android-calendar"></i>   @lang('Due Date')</b>: <span>15/09/2017 - [@lang('During') 75 @lang('days')]</span></p>
                          <p><b><i class="ion-cash"></i>   @lang('Budget')</b>: <span>10 000 000 XAF</span></p>
                          <p><b><i class="ion-person"></i>   @lang('Project Manager')</b>: <span>Max Tonye</span></p>
                          <div class="item">
                              <b>@lang('Description')</b>
                              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam in nisi quis purus faucibus lacinia ut ac urna. Phasel
                                  lus tincidunt enim tincidunt mi efficitur commodo. Mauris sit amet dui sollicitudin,
                                  pellentesque lorem a, laoreet neque. Sed et erat lacinia, rutrum ex eget, sodales nunc. Ut tincidunt laoreet lacus,
                                   et maximus odio porta vitae. Sed in luctus elit. Pellentesque maximus ante vel diam malesuada tempor.
                                   Ut id justo vitae tellus efficitur congue sit amet ac urna. Duis mattis nisl et sagittis malesuada.
                                   Maecenas velit elit, faucibus ac eleifend eu, feugiat sed purus. Aenean vitae mi sollicitudin ante venenatis suscipit
                                    non at orci. Cras porta sed nibh sit amet rutrum. Morbi cursus vulputate sapien. Nam tempus justo ut
                                    felis tempor, sed consequat sem tincidunt.</p>

                          </div>
                          <div class="item">
                              <b>@lang('Objectives')</b>
                              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam in nisi quis purus faucibus lacinia ut ac urna. Phasel
                                  lus tincidunt enim tincidunt mi efficitur commodo. Mauris sit amet dui sollicitudin,
                                  pellentesque lorem a, laoreet neque. Sed et erat lacinia, rutrum ex eget, sodales nunc. Ut tincidunt laoreet lacus,
                                   et maximus odio porta vitae. Sed in luctus elit. Pellentesque maximus ante vel diam malesuada tempor.
                                   Ut id justo vitae tellus efficitur congue sit amet ac urna. Duis mattis nisl et sagittis malesuada.
                                   Maecenas velit elit, faucibus ac eleifend eu, feugiat sed purus. Aenean vitae mi sollicitudin ante venenatis suscipit
                                    non at orci. Cras porta sed nibh sit amet rutrum. Morbi cursus vulputate sapien. Nam tempus justo ut
                                    felis tempor, sed consequat sem tincidunt.</p>

                          </div>
                      </div>
                  </div>
                  <div class="tab-pane fade" id="task" role="tabpanel" aria-labelledby="task-tab">
                      a
                  </div>
                  <div class="tab-pane fade" id="ticket" role="tabpanel" aria-labelledby="ticket-tab">
                      b
                  </div>
                </div>
            </div>
        </div>
    </section>

@endsection
