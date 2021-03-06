@extends('layouts.app')
@section('content')
    <div class="container">
        {{-- 用户查询表单 --}}
        <form class="" action="/music" method="get">
            {!! csrf_field() !!}
            <div class="breadcrumb">
                <li>曲库管理</li>
                <li class="active">曲库列表</li>
            </div>
            {{-- <fieldset> --}}
                {{-- <legend>曲目查询</legend> --}}
                <div class="form-group form-inline">
                    {{-- <label for="">用户搜索</label> --}}
                    <span>精确搜索: </span><input type="text" class="form-control" id="searchName" name="name" placeholder="请输入曲目名/作曲人" value="{{ Input::get('name') }}">
                    <input type="hidden" name="field" value="uid">
                    <input type="hidden" name="order" value="asc">
                    <button type="submit" name="button" class= "btn btn-success" id="search">搜索</button>
                </div>
            {{-- </fieldset> --}}
        </form>
        <form action="/music" method="get" id="query_condition">
            {!! csrf_field() !!}
            <div>
                <div class="h5">筛选待件:</div>
                <div class="form-inline form-group row">
                    <div class="col-md-3">
                        <div class="checkbox">
                            <label id="need-indent">
                                <input type="checkbox" name="instrument" id="input_instrument" value="@{{ instrument }}" {{ Input::get('instrument') ? 'checked' : '' }}>乐器
                            </label>
                        </div>
                        <select id="instrument" class="form-control" v-model="instrument" data-value="{{ Input::get('instrument') }}">
                            @foreach($data_condition['instrument'] as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="press" id="input_press" value="@{{ press }}" {{ Input::get('press') ? 'checked' : '' }}>出版社
                            </label>
                        </div>
                        <select id="press" class="form-control" v-model="press" data-value="{{ Input::get('press') }}">
                            @foreach($data_condition['press'] as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="category" id="input_category" value="@{{ category }}" {{ Input::get('category') ? 'checked' : '' }}>乐曲类别
                            </label>
                        </div>
                        <select id="category" class="form-control" v-model="category" data-value="{{ Input::get('category') }}">
                            @foreach($data_condition['tag'] as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="onshelf" id="input_onshelf" value="@{{ onshelf }}" {{ Input::get('onshelf') ? 'checked' : '' }}>乐曲状态
                            </label>
                        </div>
                        <select id="onshelf" class="form-control" v-model="onshelf" data-value="{{ Input::get('onshelf') }}">
                            <option value="2">已上架</option>
                            <option value="1">待审核</option>
                        </select>
                    </div>
                </div>
                <div class="form-inline form-group row">
                    <div class="col-md-3">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="organizer" id="input_organizer" value="@{{ organizer }}" {{ Input::get('organizer') ? 'checked' : '' }}>主办机构
                            </label>
                        </div>
                        <select id="organizer" class="form-control" v-model="organizer" data-value="{{ Input::get('organizer') }}">
                            @foreach($data_condition['organizer'] as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="operator" id="input_operator" value="@{{ operator }}" {{ Input::get('operator') ? 'checked' : '' }}>操作人
                            </label>
                        </div>
                        <select id="operator" class="form-control" v-model="operator" data-value="{{ Input::get('operator') }}">
                            @foreach($data_condition['operator'] as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="checkbox"id="need-indent" >
                            <label>
                                <input type="checkbox" name="version" id="input_version" value="@{{ version }}"  {{  Input::get('version') ? 'checked' : ''}}>版本
                            </label>
                        </div>
                        <select id="version" class="form-control" v-model="version" data-value="{{ Input::get('version') }}">
                            @foreach($versions as $v)
                                <option value="{{ $v->version }}">{{ $v->version }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="checkbox">
                            <label id="need-indent">
                                <input type="checkbox" name="level" id="input_level" value="@{{ level }}"  {{  Input::get('level') ? 'checked' : ''}}>级别
                            </label>
                        </div>
                        <select id="level" class="form-control" v-model="level" data-value="{{ Input::get('level') }}">
                            <option value="1">1级</option>
                            <option value="2">2级</option>
                            <option value="3">3级</option>
                            <option value="4">4级</option>
                            <option value="5">5级</option>
                            <option value="6">6级</option>
                            <option value="7">7级</option>
                            <option value="8">8级</option>
                            <option value="9">9级</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-inline">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="date" value="@{{ date }}" {{  Input::get('date') ? 'checked' : ''}}>添加日期
                    </label>
                </div>

                  <input type="text" class="form-control" id="datepicker" v-model="date" data-value="{{ Input::get('date') }}">

                <button type="submit" id="condation_search" class="btn btn-success">搜索</button>
            </div>
        </form>
        <hr>
        @if(isset($musics))
                <table class="table table-hover">
                    @if(count($musics) > 0)
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="checkAll"></th>
                                <th>乐器</th>
                                <th>乐曲名</th>
                                <th>作曲人</th>
                                <th>版本</th>
                                <th>出版社</th>
                                <th>主办机构</th>
                                {{-- <th>乐曲类别</th> --}}
                                <th>乐曲等级</th>
                                <th>midi地址</th>
                                <th>添加日期</th>
                                <th>乐曲状态</th>
                                <th>操作</th>
                                <th>操作人</th>
                                <th>分段时间</th>
                                <th>轨道</th>
                                <th>备注</th>
                                <th>时长(秒)</th>
                            </tr>
                        </thead>
                    @endif
                    <tbody>
                        @forelse($musics as $item)
                            <tr id="{{ $item->id or ''}}" class="list">
                                <td><input type="checkbox" name="music_action[]"></td>
                                <td class="{{ $item->instrument->id or '' }}">{{ $item->instrument->name or '' }}</td>
                                <td>{{ $item->name or ''}}</td>
                                <td>{{ $item->composer or ''}}</td>
                                <td>{{ $item->version or ''}}</td>
                                <td class="{{ $item->press_id or ''}}">
                                    {{ $item->press->name or ''}}
                                </td>
                                <td class="{{ $item->organizer_id or ''}}">
                                    {{ $item->organizer->name or ''}}
                                </td>
                                {{-- <td>
                                    @foreach($item->tags as $tag)
                                        <span class="{{ $tag->id  or ''}}">{{ $tag->name or ''}}</span>
                                    @endforeach
                                </td> --}}
                                <td class="{{ $item->level }}">{{ $item->level }}级</td>
                                <td><a href="/music/downloadMusic?name={{ $item->filename }}&newname={{ $item->name }}">{{ $item->filename ? $item->name : ''}}</a></td>
                                <td>{{ $item->created_at or ''}}</td>
                                <td>{{ $item->onshelf == 2 ? "已上架" : "待审核" }}</td>
                                <td>
                                    <button class="btn btn-xs btn-info edit" data-toggle="modal" data-target="#editPopup" data-backdrop="static">
                                        <span class="glyphicon glyphicon-edit"></span> 编辑
                                    </button>
                                    <button class="btn btn-xs btn-info putaway" {{ $item->onshelf ==2 ? 'disabled' : '' }}>
                                        <span class="glyphicon glyphicon-ok"></span> 审核通过
                                    </button>
                                    <button class="btn btn-xs btn-info delete">
                                        <span class="glyphicon glyphicon-remove"></span> 下架
                                    </button>
                                </td>
                                <td>{{ $item->user->name or ''}}</td>
                                <td>{{ $item->section_duration }}</td>
                                <td>{{ $item->track }}</td>
                                @if(!empty($item->note_content))
                                    <td>
                                        <span>{{ $item->editor->name or ''}} :</span>
                                        <span class="note_content">{{ $item->note_content or ''}}</span>
                                    </td>
                                @else
                                    <td></td>
                                @endif
                                <td>{{ $item->duration }}</td>
                            </tr>
                        @empty
                            {{-- @if(Input::get()) --}}
                            {{-- @else --}}
                            <br>
                            <div class="text-center blockquote">
                                <h3>没有查到相关结果，更换搜索关键词再试试吧</h3>
                            </div>
                            <br>
                            {{-- @endif --}}
                        @endforelse
                    </tbody>
                </table>

        @endif
        <div id="allow_all" class="btn btn-success">审核通过</div>
        <div id="off_shelf" class="btn btn-success">下架</div>
        <div id="add_one_mucis" class="btn btn-success" data-toggle="modal" data-target="#newPopup" data-backdrop="static">添加单个乐曲</div>
        <div id="add_multi_musics" class="btn btn-success">添加多个乐曲</div>
        <div class="text-center">
            @if(!empty($musics))
                {!! $musics->render() !!}
            @endif
        </div>

    {{-- 编辑窗口 --}}
    <div class="modal fade form-group" id="editPopup">
      <div class="modal-dialog" style="width: auto">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id=""></h4>
          </div>
          <div class="modal-body">
              <table class="table">
                  <thead>
                      <tr>
                          <th>乐器</th>
                          <th>乐曲名</th>
                          <th>作曲人</th>
                          <th>版本</th>
                          <th>出版社</th>
                          <th>主办机构</th>
                          {{-- <th>乐曲类别</th> --}}
                          <th>乐曲等级</th>
                          <th>分段时间</th>
                          <th>轨道数</th>
                          <th>备注</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <form id="save_detail">
                              <input type="hidden" id="edit_id">
                              <td>
                                  <select id="edit_instrument" class="form-control">
                                      @foreach($data_condition['instrument'] as $i)
                                          <option value="{{ $i->id }}">{{ $i->name }}</option>
                                      @endforeach
                                  </select>
                              </td>
                              <td><input class="form-control" type="text" id="edit_name"></td>
                              <td><input class="form-control" type="text" id="edit_composer"></td>
                              <td><input class="form-control" type="text" id="edit_version"></td>
                              <td>
                                  <select id="edit_press" class="form-control">
                                      @foreach($data_condition['press'] as $p)
                                          <option value="{{ $p->id }}">{{ $p->name }}</option>
                                      @endforeach
                                  </select>
                              </td>
                              <td>
                                  <select id="edit_organizer" class="form-control">
                                      @foreach($data_condition['organizer'] as $o)
                                          <option value="{{ $o->id }}">{{ $o->name }}</option>
                                      @endforeach
                                  </select>
                              </td>
                              {{-- <td>
                                  <select id="edit_category" class="form-control"></select>
                                  <div type="hidden" name="category_old" id="edit_category_old" value="">
                              </td> --}}
                              <td>
                                  <select class="form-control" id="edit_level" name="">
                                      <option value="1">一级</option>
                                      <option value="2">二级</option>
                                      <option value="3">三级</option>
                                      <option value="4">四级</option>
                                      <option value="5">五级</option>
                                      <option value="6">六级</option>
                                      <option value="7">七级</option>
                                      <option value="8">八级</option>
                                      <option value="9">九级</option>
                                      <option value="10">十级</option>
                                  </select>
                              </td>
                              <td>
                                  <select id="edit_section_duration" class="form-control">
                                      <option value="2">2秒</option>
                                      <option value="3">3秒</option>
                                      <option value="5">5秒</option>
                                  </select>
                              </td>
                              <td>
                                  <select id="edit_track" class="form-control">
                                      <option value="1">1</option>
                                      <option value="2">2</option>
                                      <option value="3">3</option>
                                      <option value="4">4</option>
                                  </select>
                              </td>
                              <td><input class="form-control" type="text" id="edit_notes"></td>
                          </form>
                      </tr>
                  </tbody>
              </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="save" data-dismiss="modal">保存修改</button>
          </div>
        </div>
      </div>
    </div>
    {{-- New的弹窗 --}}
    <div class="modal fade"	id="newPopup">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
				    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				    <h4 class="modal-title" id="myModalLabel">添加单个曲目</h4>
				</div>
				<div class="modal-body">
                    <form class="form-horizontal" id="add_music">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <label for="add_instrument" class="col-sm-2 control-label">乐器</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="add_instrument" name="instrument">
                                    @foreach($data_condition['instrument'] as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="add_name" class="col-sm-2 control-label">乐曲名</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="add_name" placeholder="请输入乐曲名称" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="add_composer" class="col-sm-2 control-label">作曲人</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="add_composer" name="composer" placeholder="请输入乐曲作者">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="add_version" class="col-sm-2 control-label">版本</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="add_version" name="version" placeholder="请输入版本号">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="add_press" class="col-sm-2 control-label">出版社</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="add_press" name="press">
                                    <option>请选择出版社</option>
                                    @foreach($data_condition['press'] as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="add_organizer" class="col-sm-2 control-label">主办单位</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="add_organizer" name="organizer">
                                    <option>请选择主办单位</option>
                                    @foreach($data_condition['organizer'] as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{-- <div class="form-group">
                            <label for="add_category" class="col-sm-2 control-label">乐曲类别</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="add_category" name="category">
                                    <option value="0">请选择</option>
                                </select>
                            </div>
                        </div> --}}
                        <div class="form-group">
                            <label for="add_level" class="col-sm-2 control-label">乐曲等级</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="add_level" name="level">
                                    <option value="1">一级</option>
                                    <option value="2">二级</option>
                                    <option value="3">三级</option>
                                    <option value="4">四级</option>
                                    <option value="5">五级</option>
                                    <option value="6">六级</option>
                                    <option value="7">七级</option>
                                    <option value="8">八级</option>
                                    <option value="9">九级</option>
                                    <option value="10">十级</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="add_section_duration" class="col-sm-2 control-label">分段时间</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="section_duration">
                                    <option value="2">2秒</option>
                                    <option value="3">3秒</option>
                                    <option value="5">5秒</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="add_track" class="col-sm-2 control-label">轨道数</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="track">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="add_note_content" class="col-sm-2 control-label">备注</label>
                            <div class="col-sm-10">
                                <input type="text" name="note_content" value="" id="add_note_content" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="add_midi_file" class="col-sm-2 control-label">mid文件</label>
                            <div class="col-sm-10">
                                <input type="file" name="midi_file" value="" id="add_midi_file" class="form-control">
                            </div>
                        </div>
                        <div class="" id="add_result"></div>
                    </form>
				</div>
				<div class="modal-footer">
                    <button type="button" class="btn btn-default" id="createMusic">创建</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
				</div>
			</div>
		</div>
    </div>
</div>
@endsection

@section('css')
    {{-- <link href="http://hayageek.github.io/jQuery-Upload-File/4.0.10/uploadfile.css" rel="stylesheet"> --}}
    {{-- <link rel="stylesheet" href="http://cdn.staticfile.org/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" media="screen" title="no title" charset="utf-8"> --}}
    <link rel="stylesheet" href="/css/music.css" media="screen" title="no title" charset="utf-8">
@endsection

@section('js')
    {{-- <script src="http://hayageek.github.io/jQuery-Upload-File/4.0.10/jquery.uploadfile.min.js"></script> --}}
    {{-- <script src="http://cdn.staticfile.org/moment.js/2.10.6/moment.min.js"></script> --}}
    {{-- <script src="http://cdn.staticfile.org/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script> --}}
    {{-- <script src="/js/vue.min.js"></script> --}}
    <script src="{{ elixir('js/music.js') }}"></script>
@endsection
