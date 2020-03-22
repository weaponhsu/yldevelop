<?php

/**
 * Created by Unknown
 *
 *            ┏┓　　  ┏┓+ +
 *           ┏┛┻━━━━━┛┻┓ + +
 *           ┃         ┃ 　
 *           ┃   ━     ┃ ++ + + +
 *          ████━████  ┃+
 *           ┃　　　　　 ┃ +
 *           ┃　　　┻　　┃
 *           ┃　　　　　 ┃ + +
 *           ┗━┓　　　┏━┛
 *             ┃　　　┃　　　　
 *             ┃　　　┃ + + + +
 *             ┃　　　┃    Code is far away from bug with the alpaca protecting
 *             ┃　　　┃ + 　　　　        神兽保佑,代码无bug
 *             ┃　　　┃
 *             ┃　　　┃　　+
 *             ┃     ┗━━━┓ + +
 *             ┃         ┣┓
 *             ┃ 　　　　　┏┛
 *             ┗┓┓┏━━┳┓┏━┛ + + + +
 *              ┃┫┫  ┃┫┫
 *              ┗┻┛  ┗┻┛+ + + +
 * User: MotherFucker
 * Date: 2016-07-18
 * Time: 下午 4:26
 */
require_once __DIR__ . '/GeneratedCode.php';

class GeneratedPhtmlV1 extends GeneratedCode
{
    private $__table_name = '';
    private $__module_name = '';
    private $__module_display_name = '后台';
    private $__controller_name = '';
    private $__controller_display_name = '';
    private $__action_name = '';
    private $__action_display_name = '管理';
    private $__file_path = '';
    private $__table_construct = '';
    private $__foreign_result = '';
    private $__filter_parameter_arr = [];

    public function setTableName($table_name){
        $this->__table_name = $table_name;
        return $this;
    }

    public function generatedPhtmlCode($file_path = '', $filter_parameter_arr = []){
        $code = '';
        $this->__file_path = $file_path;
        $this->__filter_parameter_arr = $filter_parameter_arr;
        $this->__table_name = substr($file_path, strrpos($file_path, '/')+1, strrpos($file_path, ".") - strrpos($file_path, '/') - 1);
        $this->__module_name = '';
        $file_path = str_replace(["\\", "/"], "/", $file_path);
        $file_path_arr = explode('/', $file_path);
        foreach($file_path_arr as $index => $file){
            if(strpos($file, ".phtml") !== false){
                $this->__action_name = substr($file, 0, strrpos($file, "."));
            }else{
                if($index == count($file_path_arr) - 4){
                    $this->__module_name = strtolower($file);
                }else if($index == count($file_path_arr) - 2){
                    $this->__table_name = strtolower($file);
                    $this->__table_construct = $this->_getTableConstruct($this->__table_name);
                    $this->__foreign_result = $this->_getForeignRelationship($this->__table_name);
                    $this->__controller_display_name = substr($this->_getTableComment($this->__table_name)[0][1], strrpos($this->_getTableComment($this->__table_name)[0][1], '=')+1);
                    $this->__controller_display_name = str_replace(['\'', '"'], '', $this->__controller_display_name);
                    $this->__action_display_name = $this->__controller_display_name . $this->__action_display_name;
                    $real_file_name = explode('_', $this->__table_name);
                    if(count($real_file_name) > 1){
                        foreach($real_file_name as $index => $value){
                            $real_file_name[$index] = $index > 0 ? ucfirst($value) : $value;
                        }
                        $file = implode('', $real_file_name);
                    }
                    $this->__controller_name /*= $this->__table_name*/ = $file;
                }
            }
        }
        switch ($this->__action_name){
            case 'index':
                $code .= $this->__genIndexHtml();
//                $code .= $this->__genJqGridScript();
                $code .= $this->__genJqGridScriptV1();
                break;
            case 'create':
            case 'edit':
                $code .= $this->__genCreateHtml();
                break;
        }
        return $code;
    }

    private function __genFilterHtml(){
        $sql = $construct_sql = $match_arr = [];
        $code = '';
        if(!empty($this->__foreign_result)){
            foreach($this->__foreign_result as $index => $value){
                foreach($this->__filter_parameter_arr as $key => $val){
                    switch ($key) {
                        case 'filter_column':
                            if((!is_array($val) && $value['column'] == $val) || (is_array($val) && in_array($value['column'], $val))){
                                $match_arr[$key][] = $value['column'];
                                if(preg_match_all('"<(.*):(.*)>"', str_replace('"', '', $value['comment']), $master_table_id)){
                                    $sql[$key][] = "select `id`, `name` from `" . $master_table_id[1][0] . "`";
                                    $construct_sql[$key][] = $master_table_id[1][0];
                                }
                            }
                            break;
                    }
                }
                /*if(in_array($value['column'], $this->__filter_parameter_arr) !== false){
                    $key = array_search($value['column'], $this->__filter_parameter_arr);
                    $match_arr[$key] = $value['column'];
                    switch ($key){
                        case 'filter_column':
                            if(preg_match_all('"<(.*):(.*)>"', str_replace('"', '', $value['comment']), $master_table_id)){
                                $sql[$key] = "select `id`, `name` from `" . $master_table_id[1][0] . "`";
                                $construct_sql[$key] = $master_table_id[1][0];
                            }
                            break;
                    }
                }*/
            }

            if(!empty($sql)){
                /*foreach($sql as $key => $sql_str){*/
                $code = '<div class="row">';
                foreach($sql as $key => $sql_arr){
                    foreach($sql_arr as $index => $sql_str){
                        foreach($this->_getTableConstruct($construct_sql[$key][$index]) as $k => $v) {
                            if ($v['Field'] == 'name') {
                                $code .= '#                         <div class="col-xs-12">#                             <div class="col-sm-12">'.
                                    '#                                 <h5>筛选条件('. $v['Comment'] .')：</h5>';
                            }
                        }
                        $code .= '#                                     <button onclick="filterTableData(\'all\', \''. $match_arr[$key][$index] .'\')" class="btn btn-sm btn-primary" style="height: 30px; line-height: 15px; padding: 0 10px;">全部</button>';
                        foreach($this->_getResult($sql_str) as $value){
                            $code .= '#                                     <button onclick="filterTableData(\'' . $value['id'] . '\', \''. $match_arr[$key][$index] .'\')" class="btn btn-sm btn-primary" style="height: 30px; line-height: 15px; padding: 0 10px;">' . $value['name'] . '</button>';
                        }
                        $code .= '#                             </div>#                         </div>';
                    }
                }
                $code .= '#                     </div>#                     <script src="/assets/admin/js/gamehome/common.js"></script>';
            }
        }

        return $code;
    }

    private function __genIndexHtml(){ 
        $code = '<div class="main-content">'.
'#    <div class="breadcrumbs" id="breadcrumbs">'.
'#        <script type="text/javascript">try{ace.settings.check("breadcrumbs" , "fixed")}catch(e){}</script>'.
'#        <ul class="breadcrumb">'.
'#            <li>'.
'#                <i class="icon-home home-icon"></i>'.
'#                <a href="">' . $this->__module_display_name . '</a>'.
'#            </li>'.
'#            <li>'.
'#                <a href="">' . $this->__controller_display_name . '</a>'.
'#            </li>'.
'#            <li class="active">' . $this->__action_display_name . '</li>'.
'#        </ul><!-- .breadcrumb -->'.
'#    </div>'.
'#    <div class="page-content" data-ajax-content="<?php echo $csrf;?>">'.
'#        <div class="page-header">'.
'#            <h1>'.
'#                '. $this->__controller_display_name .
'#                <small>'.
'#                    <i class="icon-double-angle-right"></i>'.
'#                    '. $this->__action_display_name .
'#                </small>'.
'#            </h1>'.
'#        </div>'.
'##        <div class="row">'.
'#            <div class="col-xs-12">'.
'#                 <div class="col-sm-4">'.
'#                      <div class="form-group">'.
'#                             <form id="file-form" action="/common/common/upload" method="post" enctype="multipart/form-data">'.
'#                                 <input type="file" name="file" id="id-input-file" />'.
'#                                 <input type="hidden" name="table_name" value="' . $this->__table_name . '" />'.
'#                             </form>'.
'#                         </div>'.
'#                     </div>'.
'#                     <div class="col-sm-4">'.
'#                         <button id="import" class="btn btn-sm btn-primary" style="height: 30px; line-height: 15px; padding: 0 10px;">导入</button>'.
'#                         <button id="export" class="btn" style="height: 30px; line-height: 15px; padding: 0 10px;">导出</button>'.
'#                     </div>'.
'#                     ' . $this->__genFilterHtml().
'##                <div class="hr hr-24"></div>'.
'##                <table id="grid-table"></table>'.
'#                <div id="grid-pager"></div>'.
'#                <script type="text/javascript">var $path_base = "/";</script>'.
'#            </div>'.
'#       </div>'.
'#    </div>'.
'#</div>';

        return str_replace("#", "\r\n", $code);
    }

    private function __genCreateHtml(){
        $code = '<div class="main-content">'.
'#    <div class="breadcrumbs" id="breadcrumbs">'.
'#        <script type="text/javascript">try{ace.settings.check("breadcrumbs" , "fixed")}catch(e){}</script>'.
'##        <ul class="breadcrumb">'.
'#            <li>'.
'#                <i class="icon-home home-icon"></i>'.
'#                <a href="">module</a>'.
'#            </li>'.
'#            <li>'.
'#                <a href=""">controller</a>'.
'#            </li>'.
'#            <li class="active">action</li>'.
'#        </ul><!-- .breadcrumb -->'.
'#    </div>'.
'#    <div class="page-content">'.
'#        <div class="page-header">'.
'#            <h1>'.
'#                h1'.
'#                <small>'.
'#                    <i class="icon-double-angle-right"></i>'.
'#                    action'.
'#                </small>'.
'#            </h1>'.
'#        </div>'.
'#        <div class="row">'.
'#            <div class="col-xs-4">'.
'#                <?php echo $form; ?>'.
'#            </div>'.
'#        </div>'.
'#    </div>'.
'#</div>';
        return str_replace('#', "\r\n", $code);
    }

    public function __genJqGridScript(){
//        $table_column = $this->_getTableConstruct($this->__table_name);
//        $foreign_result = $this->_getForeignRelationship($this->__table_name);
        if(empty($this->__table_construct)){
            throw new Exception($this->__table_name . '表不存在,无法生成curd模块');
        }
        $foreign_column_arr = [];
        foreach($this->__foreign_result as $index => $value){
            $foreign_column_arr[$value['column']] = $value['column'];
        }
        $sortname = 'id';
        foreach ($this->__table_construct as $column){
            $sortname = $column['Key'] == 'PRI' && $column['Field'] != 'id' && $sortname == 'id' ? $column['Field'] : $sortname;
            $edittype = strpos($column['Type'], 'varchar') !== false ?
                (substr($column['Type'], strrpos($column['Type'], '(') + 1, strrpos($column['Type'], ')') - strrpos($column['Type'], '(') - 1) > 16 ? 'textarea' : false) :
                (strpos($column['Type'], 'text') !== false ? 'texarea' : false);
            $length = strpos($column['Type'], 'varchar') !== false ? (substr($column['Type'], strrpos($column['Type'], '(') + 1, strrpos($column['Type'], ')') - strrpos($column['Type'], '(') - 1)) * 2 : '100';
            $search = !isset($foreign_column_arr[$column['Field']]) ? "true" : "false";
//            var_dump(($edittype === false ? '' : ", edittype: '" . $edittype . "'"));
            $model_arr[] = $column['Extra'] != 'auto_increment' ?
                "{name: '" . $column['Field'] . "', index: '" . $column['Field'] . "', width: " . ($length <= '55' ? '55' : $length) . ", editable: true". ($edittype === false ? '' : (", edittype: '" . $edittype . "'")) . ", search: " . $search . "}" :
                "{name: '" . $column['Field'] . "', index: '" . $column['Field'] . "', width: 55, search: ". $search . "}";
            $field_arr[] = $column['Field'];
            $comment_arr[] = substr(
                $column['Comment'],
                0,
                (stripos($column['Comment'], '.<') !== false ?
                    stripos($column['Comment'], '.<') :
                    (stripos($column['Comment'], '.{<') !== false ? stripos($column['Comment'], '.{<') : strlen($column['Comment']))
                )
            ) /*. '[' . ($column['Type']) . ']'*/;
        }
        $url = '/' . $this->__module_name . '/' . $this->__controller_name . '/' . $this->__action_name;

        $code = "<script src='/assets/admin/js/date-time/bootstrap-datepicker.min.js'></script>".
            "%<script src='/assets/admin/js/jqGrid/jquery.jqGrid.min.js'></script>".
            "%<script src='/assets/admin/js/jqGrid/i18n/grid.locale-zh_CN.js'></script>".
            "%<script>".
            "%jQuery(function(@) {".
            "%    $('#id-input-file').ace_file_input({".
            "%            no_file:'请选择要上传的" . $this->__table_name . "表的xls文件',".
            "%            btn_choose:'选择文件',".
            "%            btn_change:'更换文件',".
            "%            droppable:true,".
            "%            onchange:null,".
            "%            thumbnail:true,".
            "%            whitelist: 'xls',".
            "%            icon_remove: null,".
            "%            blacklist:'zip|php'".
            "%        });".
            "%        $('#import').on('click', function(){".
            "%            $('#file-form').submit();".
            "%        });".
            "%        $('#export').on('click', function(){".
            "%            window.location.href = '/common/common/export?table=" . $this->__table_name . "';".
            "%        });".
            "%        var grid_selector = '#grid-table';".
            "%        var pager_selector = '#grid-pager';".
            "%        jQuery(grid_selector).jqGrid({".
            "%            url:'". str_replace($this->__action_name, 'data', $url) ."',".
            "%            datatype: 'json',".
            "%            mtype: 'POST',".
            "%            height: 650,".
            "%            colNames:['". implode("','", $comment_arr) . "'],".
            "%            colModel :". str_replace('"', '', json_encode($model_arr)).",".
            "%            viewrecords : true,".
            "%            rowNum: 20,".
            "%            pager : pager_selector,".
            "%            altRows: true,".
            "%            multiselect: true,".
            "%            multiboxonly: false,".
            "%            jsonReader: {".
            "%                id: 'id', //相当于设置主键".
            "%                root: 'data', //Json数据".
            "%                total: 'meta.total_pages', //总页数".
            "%                page: 'meta.current_page',//当前页".
            "%                records: 'meta.total_result', //总记录数".
            "%                repeatitems: true".
            "%            },".
            "%            sortname: '". $sortname ."',".
            "%            sortorder: 'desc',".
            "%            caption: '用户列表',".
            "%            loadError : function(xhr){".
            "%                alert('error');".
            "%            },".
            "%            loadComplete: function(xhr){},".
            "%            editurl: '". str_replace($this->__action_name, 'operation', $url) ."',".
            "%            autowidth: true".
            "%        });".
            "%        //navButtons".
            "%        jQuery(grid_selector).jqGrid('navGrid',pager_selector,".
            "%            { 	//navbar options".
            "%                edit: true,".
            "%                editicon : 'icon-pencil blue',".
            "%                add: true,".
            "%                addicon : 'icon-plus-sign purple',".
            "%                del: true,".
            "%                delicon : 'icon-trash red',".
            "%                search: true,".
            "%                searchicon : 'icon-search orange',".
            "%                refresh: true,".
            "%                refreshicon : 'icon-refresh green',".
            "%                view: true,".
            "%                viewicon : 'icon-zoom-in grey'".
            "%            },".
            "%            {".
            "%                //edit record form".
            "%                closeAfterEdit: true,".
            "%                recreateForm: true,".
            "%                beforeShowForm : function(e) {".
            "%                    var form = $(e[0]);".
            "%                    style_edit_form(form, 'edit');".
            "%                },".
            "%                onclickSubmit: function (params, postData) {".
            "%                    return {csrf: $(\".page-content\").attr(\"data-ajax-content\")};".
            "%                },".
            "%                afterSubmit: function(response, postData){".
            "%                    if(response.status != '200'){".
            "%                        return [false, response.statusText]".
            "%                    }else{".
            "%                        var obj = $.parseJSON(response.responseText);".
            "%                        if(obj.code == '999'){".
            "%                            return [false, obj.message]".
            "%                        }else if(obj.code != '000'){".
            "%                            for(var i = 0; i < obj.message.length; i++){".
            "%                                var message = obj.message[i].error + \",\";".
            "%                            }".
            "%                            return [false, message]".
            "%                        }else{".
            "%                            return [true]".
            "%                        }".
            "%                    }".
            "%                    refreshCSRF();".
            "%                }".
            "%            },".
            "%            {".
            "%                //new record form".
            "%                closeAfterAdd: true,".
            "%                recreateForm: true,".
            "%                viewPagerButtons: false,".
            "%                beforeShowForm : function(e) {".
            "%                    var form = $(e[0]);".
            "%                    style_edit_form(form, 'add');".
            "%                },".
            "%                onclickSubmit: function (params, postData) {".
            "%                    return {csrf: $(\".page-content\").attr(\"data-ajax-content\")};".
            "%                },".
            "%                afterSubmit: function(response, postData){".
            "%                    if(response.status != '200'){".
            "%                        return [false, response.statusText]".
            "%                    }else{".
            "%                        var obj = $.parseJSON(response.responseText);".
            "%                        if(obj.code == '999'){".
            "%                            return [false, obj.message]".
            "%                        }else if(obj.code != '000'){".
            "%                            for(var i = 0; i < obj.message.length; i++){".
            "%                                var message = obj.message[i].error + \",\";".
            "%                            }".
            "%                            return [false, message]".
            "%                        }else{".
            "%                            return [true]".
            "%                        }".
            "%                    }".
            "%                    refreshCSRF();".
            "%                }".
            "%            },".
            "%            {".
            "%                //delete record form".
            "%                recreateForm: true,".
            "%                beforeShowForm : function(e) {".
            "%                    var form = $(e[0]);".
            "%                    if(form.data('styled')) return false;".
            "%                    form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class=\"widget-header\" />');".
            "%                    style_delete_form(form);".
            "%                    form.data('styled', true);".
            "%                },".
            "%                onClick : function(e) {".
            "%                    alert(1);".
            "%                }".
            "%            },".
            "%            {".
            "%                //search form".
            "%                recreateForm: true,".
            "%                multipleSearch: true,".
            "%                width: 800,".
            "%                afterShowSearch: function(e){".
            "%                    var form = $(e[0]);".
            "%                    form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class=\"widget-header\" />')".
            "%                    style_search_form(form);".
            "%                },".
            "%                afterRedraw: function(){".
            "%                    style_search_filters($(this));".
            "%                },".
            "%                multipleGroup:true,".
            "%                showQuery: false".
            "%            },".
            "%            {".
            "%                //view record form".
            "%                recreateForm: true,".
            "%                beforeShowForm: function(e){".
            "%                    var form = $(e[0]);".
            "%                    form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class=\"widget-header\" />')".
            "%                }".
            "%            }".
            "%        );".
            "%        function style_search_filters(form) {".
            "%            form.find('.delete-rule').val('X');".
            "%            form.find('.add-rule').addClass('btn btn-xs btn-primary');".
            "%            form.find('.add-group').addClass('btn btn-xs btn-success');".
            "%            form.find('.delete-group').addClass('btn btn-xs btn-danger');".
            "%        }".
            "%        function style_search_form(form) {".
            "%            var dialog = form.closest('.ui-jqdialog');".
            "%            var buttons = dialog.find('.EditTable')".
            "%            buttons.find('.EditButton a[id*=\"_reset\"]').addClass('btn btn-sm btn-info').find('.ui-icon').attr('class', 'ace-icon fa fa-retweet');".
            "%            buttons.find('.EditButton a[id*=\"_query\"]').addClass('btn btn-sm btn-inverse').find('.ui-icon').attr('class', 'ace-icon fa fa-comment-o');".
            "%            buttons.find('.EditButton a[id*=\"_search\"]').addClass('btn btn-sm btn-purple').find('.ui-icon').attr('class', 'ace-icon fa fa-search');".
            "%        }".
            "%        function style_delete_form(form) {".
            "%            var buttons = form.next().find('.EditButton .fm-button');".
            "%            buttons.addClass('btn btn-sm').find('[class*=\"-icon\"]').remove();//ui-icon, s-icon".
            "%            buttons.eq(0).addClass('btn-danger').prepend('<i class=\"icon-trash\"></i>');".
            "%            buttons.eq(1).prepend('<i class=\"icon-remove\"></i>')".
            "%        }".
            "%        function refreshCSRF() {".
            "%            var old_csrf = $(\".page-content\").attr(\"data-ajax-content\");".
            "%            $.ajax({".
            "%                url: \"/common/common/refresh\",".
            "%                type: \"post\",".
            "%                data: {'csrf': old_csrf},".
            "%                success: function(data){".
            "%                    if(data.msg == '000'){".
            "%                        $(\".page-content\").attr(\"data-ajax-content\", data.message)".
            "%                    }else{".
            "%                        alert(data.message);".
            "%                    }".
            "%                },".
            "%                error: function(){".
            "%                    alert('报错了');".
            "%                }".
            "%            });".
            "%        }".
            "%        function style_delete_form(form) {".
            "%            var buttons = form.next().find('.EditButton .fm-button');".
            "%            buttons.addClass('btn btn-sm').find('[class*=\"-icon\"]').remove();".
            "%            buttons.eq(0).addClass('btn-danger').prepend('<i class=\"icon-trash\"></i>');".
            "%            buttons.eq(1).prepend('<i class=\"icon-remove\"></i>')".
            "%        }".
            "%        function style_edit_form(form, oper='add') {".
            "%            if(oper == 'edit'){".
            "%                form.find('input[name=\"id\"]').parents(\"tr\").hide();".
            "%            }".
            "%        }".
            "%        $('thead tr:first th').on('mouseover', function(){".
            "%            $(this).find('div').attr('title', $(this).find('div').text());".
            "%        })".
            "%    });".
            "%</script>";
        return str_replace('%', "\r\n", str_replace("@", "$", $code));
    }

    public function __genJqGridScriptV1(){
//        $table_column = $this->_getTableConstruct($this->__table_name);
//        $foreign_result = $this->_getForeignRelationship($this->__table_name);
        if(empty($this->__table_construct)){
            throw new Exception($this->__table_name . '表不存在,无法生成curd模块');
        }
        $foreign_column_arr = [];
        foreach($this->__foreign_result as $index => $value){
            $foreign_column_arr[$value['column']] = $value['column'];
        }
        $sortname = 'id';
        foreach ($this->__table_construct as $column){
            $sortname = $column['Key'] == 'PRI' && $column['Field'] != 'id' && $sortname == 'id' ? $column['Field'] : $sortname;
            $edittype = strpos($column['Type'], 'varchar') !== false ?
                (substr($column['Type'], strrpos($column['Type'], '(') + 1, strrpos($column['Type'], ')') - strrpos($column['Type'], '(') - 1) > 16 ? 'textarea' : false) :
                (strpos($column['Type'], 'text') !== false ? 'texarea' : false);
            $length = strpos($column['Type'], 'varchar') !== false ? (substr($column['Type'], strrpos($column['Type'], '(') + 1, strrpos($column['Type'], ')') - strrpos($column['Type'], '(') - 1)) * 2 : '100';
            $search = !isset($foreign_column_arr[$column['Field']]) ? "true" : "false";
//            var_dump(($edittype === false ? '' : ", edittype: '" . $edittype . "'"));
            $model_arr[] = $column['Extra'] != 'auto_increment' ?
                "{name: '" . $column['Field'] . "', index: '" . $column['Field'] . "', width: " . ($length <= '55' ? '55' : $length) . ", editable: true". ($edittype === false ? '' : (", edittype: '" . $edittype . "'")) . ", search: " . $search . "}" :
                "{name: '" . $column['Field'] . "', index: '" . $column['Field'] . "', width: 55, search: ". $search . "}";
            $field_arr[] = $column['Field'];
            $comment_arr[] = substr(
                $column['Comment'],
                0,
                (stripos($column['Comment'], '.<') !== false ?
                    stripos($column['Comment'], '.<') :
                    (stripos($column['Comment'], '.{<') !== false ? stripos($column['Comment'], '.{<') : strlen($column['Comment']))
                )
            ) /*. '[' . ($column['Type']) . ']'*/;
        }
        $url = '/' . $this->__module_name . '/' . $this->__controller_name . '/' . $this->__action_name;

        $code = "<script src='/assets/admin/js/date-time/bootstrap-datepicker.min.js'></script>".
            "%<script src='/assets/admin/js/jqGrid/jquery.jqGrid.min.js'></script>".
            "%<script src='/assets/admin/js/jqGrid/i18n/grid.locale-zh_CN.js'></script>".
            "%<script>".
            "%jQuery(function(@) {".
            "%    $('#id-input-file').ace_file_input({".
            "%            no_file:'请选择要上传的" . $this->__table_name . "表的xls文件',".
            "%            btn_choose:'选择文件',".
            "%            btn_change:'更换文件',".
            "%            droppable:true,".
            "%            onchange:null,".
            "%            thumbnail:true,".
            "%            whitelist: 'xls',".
            "%            icon_remove: null,".
            "%            blacklist:'zip|php'".
            "%        });".
            "%        $('#import').on('click', function(){".
            "%            $('#file-form').submit();".
            "%        });".
            "%        $('#export').on('click', function(){".
            "%            window.location.href = '/common/common/export?table=" . $this->__table_name . "';".
            "%        });".
            "%        var grid_selector = '#grid-table';".
            "%        var pager_selector = '#grid-pager';".
            "%        jQuery(grid_selector).jqGrid({".
            "%            url:'" . str_replace($this->__action_name, 'data', $url) . "',".
            "%            datatype: 'json',".
            "%            mtype: 'POST',".
            "%            height: 650,".
            "%            colNames:['". implode("','", $comment_arr) . "'],".
            "%            colModel :" . str_replace('"', '', json_encode($model_arr)) . ", ".
            "%            viewrecords : true,".
            "%            rowNum: 20,".
            "%            pager : pager_selector,".
            "%            altRows: true,".
            "%            multiselect: true,".
            "%            multiboxonly: false,".
            "%            jsonReader: {".
            "%                id: 'id', ".
            "%                root: 'data', ".
            "%                total: 'meta.total_pages', ".
            "%                page: 'meta.current_page',".
            "%                records: 'meta.total_result', ".
            "%                repeatitems: true".
            "%            },".
            "%            sortname: '". $sortname ."',".
            "%            sortorder: 'desc',".
            "%            caption: '用户列表',".
            "%            loadError : function(xhr){".
            "%                alert('error');".
            "%            },".
            "%            loadComplete: function(xhr){".
            "%                var ids = $(grid_selector).jqGrid('getDataIDs');".
            "%                for(var i = 0; i < xhr.data.length; i++){ ".
            "%                     var html = '<a href=\"" . str_replace($this->__action_name, 'edit', $url) . "?id=' + xhr.data[i].id + '\" target=\"_blank\">' + xhr.data[i].id + '</a>'; ".
            "%                     $(grid_selector).jqGrid('setRowData', ids[i], {id: html});".
            "%                }".
            "%            },".
            "%            editurl: '" . str_replace($this->__action_name, 'delete', $url) . "',".
            "%            autowidth: true".
            "%        });".
            "%        /*navButtons*/".
            "%        jQuery(grid_selector).jqGrid('navGrid',pager_selector,".
            "%            { 	/*navbar options*/".
            "%                edit: false,".
            "%                editicon : 'icon-pencil blue',".
            "%                add: true,".
            "%                addicon : 'icon-plus-sign purple',".
            "%                del: true,".
            "%                delicon : 'icon-trash red',".
            "%                search: true,".
            "%                searchicon : 'icon-search orange',".
            "%                refresh: false,".
            "%                refreshicon : 'icon-refresh green',".
            "%                view: false,".
            "%                viewicon : 'icon-zoom-in grey'".
            "%            },".
            "%            {".
            "%                /*edit record form*/".
            "%                closeAfterEdit: true,".
            "%                recreateForm: true,".
            "%                beforeShowForm : function(e) {".
            "%                },".
            "%            },".
            "%            {".
            "%                /*new record form*/".
            "%                closeAfterAdd: true,".
            "%                recreateForm: true,".
            "%                viewPagerButtons: false,".
            "%                beforeShowForm : function(e) {".
            "%                    var form = $(e[0]);".
            "%                    style_edit_form(form, 'add');".
//            "%                    window.location.href = '" . str_replace($this->__action_name, 'create', $url) . "'; ".
            "%                },".
            "%            },".
            "%            {".
            "%                /*delete record form*/".
            "%                recreateForm: true,".
            "%                beforeShowForm : function(e) {".
            "%                    var form = $(e[0]);".
            "%                    if(form.data('styled')) return false;".
            "%                    form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class=\"widget-header\" />');".
            "%                    style_delete_form(form);".
            "%                    form.data('styled', true);".
            "%                },".
            "%                onClick : function(e) {".
            "%                    alert(1);".
            "%                }".
            "%            },".
            "%            {".
            "%                /*search form*/".
            "%                recreateForm: true,".
            "%                multipleSearch: true,".
            "%                width: 800,".
            "%                afterShowSearch: function(e){".
            "%                    var form = $(e[0]);".
            "%                    form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class=\"widget-header\" />')".
            "%                    style_search_form(form);".
            "%                },".
            "%                afterRedraw: function(){".
            "%                    style_search_filters($(this));".
            "%                },".
            "%                multipleGroup:true,".
            "%                showQuery: false".
            "%            },".
            "%            {".
            "%                /*view record form*/".
            "%                recreateForm: true,".
            "%                beforeShowForm: function(e){".
            "%                    var form = $(e[0]);".
            "%                    form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class=\"widget-header\" />')".
            "%                }".
            "%            }".
            "%        );".
            "%        function style_search_filters(form) {".
            "%            form.find('.delete-rule').val('X');".
            "%            form.find('.add-rule').addClass('btn btn-xs btn-primary');".
            "%            form.find('.add-group').addClass('btn btn-xs btn-success');".
            "%            form.find('.delete-group').addClass('btn btn-xs btn-danger');".
            "%        }".
            "%        function style_search_form(form) {".
            "%            var dialog = form.closest('.ui-jqdialog');".
            "%            var buttons = dialog.find('.EditTable')".
            "%            buttons.find('.EditButton a[id*=\"_reset\"]').addClass('btn btn-sm btn-info').find('.ui-icon').attr('class', 'ace-icon fa fa-retweet');".
            "%            buttons.find('.EditButton a[id*=\"_query\"]').addClass('btn btn-sm btn-inverse').find('.ui-icon').attr('class', 'ace-icon fa fa-comment-o');".
            "%            buttons.find('.EditButton a[id*=\"_search\"]').addClass('btn btn-sm btn-purple').find('.ui-icon').attr('class', 'ace-icon fa fa-search');".
            "%        }".
            "%        function style_delete_form(form) {".
            "%            var buttons = form.next().find('.EditButton .fm-button');".
            "%            buttons.addClass('btn btn-sm').find('[class*=\"-icon\"]').remove();/*ui-icon, s-icon*/".
            "%            buttons.eq(0).addClass('btn-danger').prepend('<i class=\"icon-trash\"></i>');".
            "%            buttons.eq(1).prepend('<i class=\"icon-remove\"></i>')".
            "%        }".
            "%        function style_delete_form(form) {".
            "%            var buttons = form.next().find('.EditButton .fm-button');".
            "%            buttons.addClass('btn btn-sm').find('[class*=\"-icon\"]').remove();".
            "%            buttons.eq(0).addClass('btn-danger').prepend('<i class=\"icon-trash\"></i>');".
            "%            buttons.eq(1).prepend('<i class=\"icon-remove\"></i>')".
            "%        }".
            "%        function style_edit_form(form, oper='add') {".
            "%            if(oper == 'edit'){".
            "%                form.find('input[name=\"id\"]').parents(\"tr\").hide();".
            "%            }else{".
            "%                form.parents(\"#editmodgrid-table\").remove();".
            "%                window.location.href=\"" . str_replace($this->__action_name, 'create', $url) . "\";".
            "%            }".
            "%        }".
            "%        $('thead tr:first th').on('mouseover', function(){".
            "%            $(this).find('div').attr('title', $(this).find('div').text());".
            "%        })".
            "%    });".
            "%</script>";
        return str_replace('%', "\r\n", str_replace("@", "$", $code));
    }
}