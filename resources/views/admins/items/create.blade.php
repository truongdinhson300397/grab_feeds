@extends('admins.layout.index')
@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Form Validation</h3>
                </div>

                <div class="title_right">
                    <div class="col-md-5 col-sm-5 form-group pull-right top_search">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search for...">
                            <span class="input-group-btn">
                              <button class="btn btn-default" type="button">Go!</button>
                          </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Form validation <small>sub title</small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="#">Settings 1</a>
                                        <a class="dropdown-item" href="#">Settings 2</a>
                                    </div>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <form class="form-horizontal form-label-left" action="{{route('items.store')}}" method="POST" novalidate>
                                @csrf

                                <p>For alternative validation library <code>parsleyJS</code> check out in the <a href="form.html">form page</a>
                                </p>
                                <span class="section">Personal Info</span>

                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="name">Title  <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6">
                                        <input id="title" class="form-control @error('title') is-invalid @enderror " data-validate-length-range="6" data-validate-words="2" name="title" placeholder="Name title" type="text">
                                    </div>
                                    @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message  }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="name">Description  <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6">
                                        <textarea id="description" class="form-control @error('description') is-invalid @enderror " cols="40" rows="8" name="description" placeholder="Name description" ></textarea>
                                    </div>
                                    @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message  }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 offset-md-3">
                                        <a href="{{ route('items.index') }}" class="btn btn-secondary">Cancel</a>
                                        <button id="send" type="submit" class="btn btn-success">Create</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /page content -->
@endsection
