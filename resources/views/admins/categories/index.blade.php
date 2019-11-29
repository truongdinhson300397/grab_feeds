@extends('admins.layout.index')
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Users <small>Some examples to get you started</small></h3>
                </div>
                <div class="title_right">

                    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                        <form action="{{ route('categories.index') }}" role="search">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" value="{{request('search')}}"
                                       placeholder="Search for...">
                                <span class="input-group-btn">
                                  <button class="btn btn-secondary" type="button">Go!</button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Default Example <small>Users</small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                       aria-expanded="false"><i class="fa fa-wrench"></i></a>
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
                            <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                @if(Session('status'))
                                    <div class="alert alert-success">
                                        {{Session('status')}}
                                    </div>
                                @endif
                                <a style="color:#fff" href="{{route('categories.create')}}">
                                    <button type="button" class="btn btn-primary pull-right">Create category</button>
                                </a>
                                <thead>
                                <tr>
                                    <th>
                                        ID
                                        <a href="{{route('categories.index',['sort' =>'id', 'direction' => 'asc'])}}">
                                            <button type="button">up</button>
                                        </a>
                                        <a href="{{route('categories.index',['sort' =>'id', 'direction' => 'desc' ])}}">
                                            <button type="button">down</button>
                                        </a>
                                    </th>
                                    <th>Name</th>
                                    <th>Created_at</th>
                                    <th>Updated_at</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($categories as $category)
                                    <tr>
                                        <td>{{$category->id}}</td>
                                        <td>{{$category->name}}</td>
                                        <td>{{$category->created_at}}</td>
                                        <td>{{$category->updated_at}}</td>
                                        <td>
                                            <a style="color:#fff" href="{{route('categories.show',$category->id)}}">
                                                <button type="button" class="btn btn-primary">View</button>
                                            </a>
                                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                                    data-target="#delete{{$category->id}}">
                                                Delete
                                            </button>
                                            <!-- Modal delete-->
                                            <div class="modal fade" id="delete{{$category->id}}" tabindex="-1"
                                                 role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Delete
                                                                article</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Do you want to delete
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form id="delete-form"
                                                                  action="{{route('categories.destroy',$category->id)}}"
                                                                  method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <input type="submit" class="btn btn-danger" value="Yes">
                                                            </form>
                                                            <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">No
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                            <div class="row" style="margin-left: 2px">{{$categories->links()}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /page content -->
@endsection
