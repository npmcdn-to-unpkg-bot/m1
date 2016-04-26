$(document).ready(function() {
    /**
     * 点击"创建"按钮(相当于点击"新建"之后的保存)
     */
    $("#createMusic").click(function() {
        ajaxSubmitForm();
        function ajaxSubmitForm() {
           var value = $("#add_midi_file").val();
        //    验证上传文件是否为空
           if (isEmpty(value)) {
               alert('请先添加文件');
               return false;
           }else if (isEmpty($("#add_name").val())) {
               alert('乐曲名不能为空');
               return false;
           }else if (isEmpty($("#add_composer").val())) {
               alert('作曲人不能为空');
               return false;
           }
           /**
            * 验证变量是否为空
            * @method isEmpty
            * @param  {[type]}  inputStr [传入变量]
            * @return {Boolean}          [返回的boolean值]
            */
           function isEmpty( inputStr ) {
               if ( null == inputStr || "" == inputStr ) {
                   return true;
               }
               return false;
            }
           if (!value.match(/.mid/i)) {
               alert("文件格式错误");
               return false;
           }


           var option = {
               url : 'music',
               type : 'POST',
               dataType : 'json',
               data: {
                   'instrument': $("#add_instrument").val(),
                   'name': $("#add_name").val(),
                   'composer': $("#add_composer").val(),
                   'version': $("#add_version").val(),
                   'press': $("#add_press").val(),
                   'organizer': $("#add_organizer").val(),
                   'category': $("#add_category").val(),
                   'level': $("#add_level").val(),
                   'note_content': $("#add_note_content").val(),
               },
               headers : {
                //    "ClientCallMode" : "ajax"
                   'X-CSRF-TOKEN': $('input[name="_token"]').val()
               }, //添加请求头部
               success : function(data) {
                //    $("#addResult").html("添加成功");
                //    $("#addResult").hide('slow', function() {
                   //
                //    });

                    alert('添加成功!');
                    $("#newPopup").modal('hide');

               },
               error : function(data) {
                //    console.log(JSON.stringify(data) + "--上传失败,请刷新后重试");
                alert('上传失败,请刷新后重试!');
               }
           };
           $("#add_music").ajaxSubmit(option);
           return false; // 最好返回false，因为如果按钮类型是submit,则表单自己又会提交一次;返回false阻止表单再次提交
        }
    });

    // 点击"编辑"按钮
    $(".edit").each(function(index, el) {
        $(this).click(function() {
            $("#edit_id").val($(el).closest('tr').attr('id'));                                      // 乐曲id
            $("#edit_instrument").val($(el).closest('tr').find('td:eq(1)').attr('class'));          // 乐器
            $("#edit_name").val($(el).closest('tr').find('td:eq(2)').text());                       // 乐曲名
            $("#edit_composer").val($(el).closest('tr').find('td:eq(3)').text());                   // 作曲人
            $("#edit_version").val($(el).closest('tr').find('td:eq(4)').text());                    // 版本
            $("#edit_press").val($(el).closest('tr').find('td:eq(5)').attr('class'));               // 出版社
            $("#edit_organizer").val($(el).closest('tr').find('td:eq(6)').attr('class'));           // 主办机构
            // $("#edit_category").val($(el).closest('tr').find('td:eq(7) span').attr('class'));       // 乐曲类别
            $("#edit_level").val($(el).closest('tr').find('td:eq(7)').attr('class'));          // 乐曲等级
            $("#edit_category_old").val($(el).closest('tr').find('td:eq(7) span').attr('class'))    // 改变之前的"乐曲类别"
            $("#edit_section_duration").val($.trim($(el).closest('tr').find('td:eq(13)').text()));  // 分段时间
            $("#edit_track").val($.trim($(el).closest('tr').find('td:eq(14)').text()));             // 轨道
            $("#edit_notes").val($(el).closest('tr').find('.note_content').text());                 // 备注
        });
    });


    // 点击"保存修改"按钮
    $("#save").bind('click', function(event) {
        ajaxSubmitForm();
        function ajaxSubmitForm() {
            var $id_value = $("#edit_id").val();
            var option = {
                url : 'music/' + $id_value,
                type : 'put',
                dataType : 'json',
                data : {
                    'id': $("#edit_id").val(),
                    'instrument': $("#edit_instrument").val(),
                    'name': $("#edit_name").val(),
                    'composer': $("#edit_composer").val(),
                    'version': $("#edit_version").val(),
                    'press': $("#edit_press").val(),
                    'organizer': $("#edit_organizer").val(),
                    // 'category': $("#edit_category").val(),
                    // 'category_old': $("#edit_category_old").val(),
                    'level': $("#edit_level").val(),
                    'section_duration': $("#edit_section_duration").val(),
                    'track': $("#edit_track").val(),
                    'notes': $("#edit_notes").val()
                },
                headers : {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                success : function(data) {
                    location.reload();
                },
                error : function(data) {
                    alert('哦，出了点小问题，再试一次吧');
                }
                // error : function(data) {
                //     alert(JSON.stringify(data) + "--添加失败, 请重试");
                // }
            }
            $("#save_detail").ajaxSubmit(option);
            return false;
        }
    });
    /**
     * 点击"审核通过"按钮
     */
    $(".putaway").each(function(index, el) {
        $(this).bind('click', function(event) {
            $.getJSON('/music/putaway/' + $(el).closest('tr').attr('id'), function(json, textStatus) {
                console.log('操作成功');
            });
        });
    });
    // 点击"删除"按钮
    $(".delete").each(function(indel, el) {
        $(this).bind('click', function(event) {
            $.ajax({
                url: '/music/' + $(el).closest('tr').attr('id'),
                type: 'DELETE',
                dataType: 'json',
                headers : {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                }
            })
            .done(function() {
                console.log("success");
                $(el).closest('tr').remove();

            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {
                console.log("complete");
            });
        });
    });

    /**
     * 自动拉取筛选条件列表
     */
    $.ajax({
        url: '/music/condations',
        type: 'GET',
        dataType: 'json',
        headers : {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        }
    })
    .done(function(data) {
        /**
         * 拉取“乐器”列表
         */
        $.each(data.instrument, function(n, value) {
            var $str = "";
            $str = "<option value=" + value.id + ">" + value.name + "</option>";
            $("#instrument").append($str);
            $("#instrument").val("1");
            $("#edit_instrument").append($str);
            $("#add_instrument").append($str);
            // 保持搜索条件
            if (instrument != '' && instrument != null) {
                $("#instrument").val(instrument);
                $("input[name=instrument]").val(instrument);
                $("input[name=instrument]").prop('checked', true);
            }
        });

        /**
         * 拉取“出版社”列表
         */
        $.each(data.press, function(n, value) {
            var $str = "";
            $str = "<option value=" + value.id + ">" + value.name + "</option>";
            $("#press").append($str);
            $("#edit_press").append($str);
            $("#add_press").append($str);
            // 保持搜索条件
            if (press != '' && press != null) {
                $("#press").val(press);
                $("input[name=press]").val(press);
                $("input[name=press]").prop('checked', true);
            }
        });

        /**
         * 拉取"乐曲类别"列表
         */
        $.each(data.tag, function(n, value) {
            var $str = "";
            $str = "<option value=" + value.id + ">" + value.name + "</option>";
            $("#category").append($str);
            $("#edit_category").append($str);
            $("#add_category").append($str);
            // 保持搜索条件
            if (category != '' && category != null) {
                $("#category").val(category);
                $("input[name=category]").val(category);
                $("input[name=category]").prop('checked', true);
            }
        });

        /**
         * 拉取"主办机构"列表
         */
        $.each(data.organizer, function(n, value) {
            var $str = "";
            $str = "<option value=" + value.id + ">" + value.name + "</option>";
            $("#organizer").append($str);
            $("#edit_organizer").append($str);
            $("#add_organizer").append($str);
            // 保持搜索条件
            if (organizer != '' && organizer != null) {
                $("#organizer").val(organizer);
                $("input[name=organizer]").val(organizer);
                $("input[name=organizer]").prop('checked', true);
            }
        });

        /**
         * 拉取"操作人"列表
         */
        $.each(data.operator, function(n, value) {
            var $str = "";
            $str = "<option value=" + value.id + ">" + value.name + "</option>";
            $("#operator").append($str);
            // 保持搜索条件
            if (operator != '' && operator != null) {
                $("#operator").val(operator);
                $("input[name=operator]").val(operator);
                $("input[name=operator]").prop('checked', true);
            }
        });
    })
    .fail(function(data) {
        console.log(data);
    });

    /**
     * select下拉式日期选择器
     */
     var myDate = new Date();
     $("#dateSelector").DateSelector({
     ctlYearId: 'idYear',
     ctlMonthId: 'idMonth',
     ctlDayId: 'idDay',
     defYear: myDate.getFullYear(),
     defMonth: (myDate.getMonth() + 1),
     defDay: myDate.getDate(),
     minYear: 2015,
     maxYear: (myDate.getFullYear() + 1)
     });

    $("#date").val($("#idYear").val() + '-' + $("#idMonth").val() + '-' + $("#idDay").val());
    $(".date_select").each(function(index, el) {
        $(el).bind('change', function() {
            // $(el).closest('input').val($(el).val());
            // $(el).siblings('input').val($(el).val());
            if ($(el).attr('id') === 'idYear' || $(el).attr('id') === 'idMonth' || $(el).attr('id') === 'idDay') {
                $("#date").val($("#idYear").val() + '-' + $("#idMonth").val() + '-' + $("#idDay").val());
            }
        });
    });
    // 保持搜索条件
    var date = $.getUrlParam('date');
    if (date != '' && date != null) {
        $("#idYear").val(date.split('-')[0]);
        $("#idMonth").val(date.split('-')[1]);
        $("#idDay").val(date.split('-')[2]);
        $("input[name=date]").val(date);
        $("input[name=date]").prop('checked', true);
    }

    /**
     * select中选择值改变的时候，同步给select的value赋值
     */
    $("select").each(function(index, el) {
        $(el).bind('change', function(event) {
            $(el).siblings('input').val($(el).val());
            console.log($(el).val());
        });
    });

    /**
     * 点击“添加多个乐曲”跳转到指定页面
     */
    $("#add_multi_musics").bind('click', function(event) {
        window.location.href = "/music/create";
    });

    /**
     * 全部选中，全部取消
     */
    $("#checkAll").bind('click', function(event) {
        if (this.checked) {
            $("input[name='music_action[]']").prop("checked", true);
        }else {
            $("input[name='music_action[]']").prop("checked", false);
        }
    });

    /**
     * 批量审核通过
     */
    $("#allow_all").bind('click', function() {
        var ids = [];
        $("input[name='music_action[]']:checked").each(function(index, el) {
            ids.push($(el).closest('tr').attr('id'));
        });
        $confirm = confirm('确认要批量审核通过所选乐曲?');
        if ($confirm) {
            $.ajax({
                url: '/music/putawayMany',
                type: 'PUT',
                dataType: 'json',
                data: {'ids': ids},
                headers: {
                    'X-CSRF-TOKEN': $("input[name='_token']").val()
                }
            })
            .done(function() {
                location.reload();
            })
        }
    });

    /**
     * 批量下架
     */
    $("#off_shelf").bind('click', function () {
        var ids = [];
        $("input[name='music_action[]']:checked").each(function(index, el) {
            ids.push($(el).closest('tr').attr('id'));
        });
        $confirm = confirm('确认要批量下回所选乐曲?');
        if ($confirm) {
            $.ajax({
                url: '/music/offshelfMany',
                type: 'DELETE',
                dataType: 'json',
                data: {'ids': ids},
                headers: {
                    'X-CSRF-TOKEN': $("input[name='_token']").val()
                }
            })
            .done(function() {
                location.reload();
            })
        }

    });

    // 获取 URL 中的参数
    var name       = $.getUrlParam('name');
    var instrument = $.getUrlParam('instrument');
    var press      = $.getUrlParam('press');
    var category   = $.getUrlParam('category');
    var onshelf    = $.getUrlParam('onshelf');
    var organizer  = $.getUrlParam('organizer');
    var operator   = $.getUrlParam('operator');
    if (name != '' && name != null) {
        $("input[name=name]").val(name);
    }

    if (onshelf != '' && onshelf != null) {
        $("#onshelf").val(onshelf);
        $("input[name=onshelf]").val(onshelf);
        $("input[name=onshelf]").prop('checked', true);
    }
});
