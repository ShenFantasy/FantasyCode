@extends('layouts.app')

@section('content')
    @include('shared._error')

    <div class="ui centered grid container stackable">
        <div class="twelve wide column">
            <div class="ui segment">
                <a class="ui right corner label compose-help" href="javascript:;">
                    <i class="info icon"></i>
                </a>

                <div class="content extra-padding">

                    <div class="ui header text-center text gery" style="margin:10px 0 40px">
                        @if($topic->id)
                            <i class="icon paint brush"></i>
                            编辑博文
                        @else
                            <i class="icon paint brush"></i>
                            新建博文
                        @endif
                    </div>

                    @if($topic->id)
                        <form id="article-update-form"
                              class="ui form"
                              style="min-height: 50px;"
                              action="{{ route('topics.update', $topic->id) }}" method="POST" accept-charset="UTF-8">
                            <input type="hidden" name="_method" value="PUT">
                            @else
                                <form id="article-create-form"
                                      style="min-height: 50px;"
                                      class="ui form"
                                      action="{{ route('topics.store') }}" method="POST" accept-charset="UTF-8">
                                    @endif
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <div class="field">
                                        <label for="">标题</label>
                                        <input class="form-control" type="text" name="title"
                                               id="title-field" value="{{ old('title', $topic->title ) }}"
                                               placeholder="请填写标题" required="">
                                    </div>

                                    <div class="field">
                                        <label>分类
{{--                                            <a target="_blank" href="{{ route('topics.index') }}">管理分类</a>--}}
                                        </label>
                                        <div class="field">
                                            <div class="ui fluid selection dropdown">
                                                {{-- 设置此值会自动设置默认值 --}}
                                                <input type="hidden" name="category_id" value="{{ old('category_id', $topic->category_id) }}">
                                                <i class="dropdown icon"></i>
                                                <div class="default text">请选择分类标签（必选）</div>
                                                <div class="menu">
                                                    @foreach ($categories as $value)
                                                        <div class="item" data-value="{{ $value->id }}">
                                                            {{ $value->name }}
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <label>选择标签（Tab 键可创建新标签）</label>
                                        <div class="ui search multiple selection tags dropdown " >
                                            <input type="hidden" name="tags" value="{{ isset($topicTags) ? $topicTags : '' }}" >
                                            <i class="dropdown icon"></i>
                                            <input type="text" class="search">
                                            <div class="default text">请选择标签（选填）</div>
                                            <div class="menu">
                                                @foreach ($tags as $value)
                                                    <div class="item" data-value="{{ $value->name }}">
                                                        {{ $value->name }}
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    {{-- 加载 markdown 编辑器 --}}
                                    <div class="markdown-base">
                                    <textarea
                                        id="markdown-editor"
                                        name="body"
                                        placeholder="请输入至少三个字符的内容。"
                                        rows="6">{{ old('body', $topic->body ) }}</textarea>
                                    </div>

                                    <div class="ui segment private-checkbox">
                                        <div class="field">
                                            <div class="ui toggle checkbox">
                                                <input type="checkbox" id="pasteFromClickBoard" name="pasteFromClickBoard" tabindex="0" class="hidden" value="yes">
                                                <label>剪贴板内容格式化 Markdown</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div contenteditable="true" id="pastebin"></div>

                                    <div class="ui message">
                                        <button type="submit" class="ui button green publish-btn loading-on-clicked" id="">
                                            <i class="icon send"></i>
                                            发布文章
                                        </button>

{{--                                        <a class="pull-right" href="/" target="_blank" style="color: #777;font-size: .9em;text-decoration: underline;margin-top: 8px;">--}}
{{--                                            <i class="icon wpforms"></i> 编辑器使用指南--}}
{{--                                        </a>--}}
                                    </div>
                                </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('common.markdown_edit')
    <script type="text/javascript">
        var markdown = new Markdown();
        markdown.init({
            'textarea': {
                'id': 'markdown-editor',
            }
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.tags.ui.dropdown').dropdown({
                allowAdditions: true,
                saveRemoteData : false,
                onChange: function (value, text, $selectedItem) {
                }
                /*apiSettings: {
                    url: 'https://learnku.com/articles/tags/search?q={query}',
                    cache: false
                }*/
            });
        });
    </script>
@endsection
