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

class GeneratedPhtml extends GeneratedCode
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
                $this->__action_display_name = '新建' . $this->__controller_display_name;
                $code .= $this->__genCreateHtml();
                break;
            case 'edit':
                $this->__action_display_name = '修改' . $this->__controller_display_name;
                $code .= $this->__genEditHtml();
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
        $ueditor_js = false;
        $album_upload_js = false;
        $thumb_upload_js = false;
        $require_css = '';
        $require_js = '';
        $resource_js_include = false;
        $resource_upload_var = '';
        $resource_upload_js = '';
        foreach ($this->__table_construct as $column){
            //字段备注中包含"(avatar)"或"(thumb)" 并且字段类型为varchar 意为保存图片文件名
            if((strpos($column['Comment'], '(thumb)') !== false || strpos($column['Comment'], '(avatar)') !== false)
                && strpos($column['Type'], 'varchar') !== false){
                $require_css = '<link rel="stylesheet" href="/assets/admin/css/webuploader.css" /><link rel="stylesheet" href="/assets/admin/css/webuploader.container.css" />';
                $require_js .= '<script src="/assets/qiniu/src/qiniu.js"></script>'.
                    '<script src="/assets/plupload/js/moxie.min.js"></script>'.
                    '<script src="/assets/plupload/js/plupload.dev.js"></script>'.
                    '<script src="/assets/admin/js/37eGoWebuploader.js"></script>';
                $thumb_upload_js = "var uploader = Qiniu.uploader({
            runtimes: 'html5',    //上传模式,依次退化
            browse_button: 'pickfiles',       //上传选择的点选按钮，**必需**
            uptoken_url: '/common/qiniu/qiniuAuth?file_type=". ($this->__table_name == 'store' ? $this->__table_name . '_' . $column['Field'] : $this->__table_name) ."',            //Ajax请求upToken的Url，**强烈建议设置**（服务端提供）
            // uptoken : '', //若未指定uptoken_url,则必须指定 uptoken ,uptoken由其他程序生成
            unique_names: true, // 默认 false，key为文件名。若开启该选项，SDK为自动生成上传成功后的key（文件名）。
            // save_key: true,   // 默认 false。若在服务端生成uptoken的上传策略中指定了 `sava_key`，则开启，SDK会忽略对key的处理
            domain: 'http://oka115078.bkt.clouddn.com/',   //bucket 域名，下载资源时用到，**必需**
            get_new_uptoken: false,  //设置上传文件的时候是否每次都重新获取新的token
            container: 'container',           //上传区域DOM ID，默认是browser_button的父元素，
            max_file_size: '3mb',           //最大文件体积限制
            flash_swf_url: 'js/plupload/Moxie.swf',  //引入flash,相对路径
            max_retries: 3,                   //上传失败最大重试次数
            dragdrop: false,                   //开启可拖曳上传
            drop_element: 'pickfiles',        //拖曳上传区域元素的ID，拖曳文件或文件夹后可触发上传
            chunk_size: '4mb',                //分块上传时，每片的体积
            auto_start: true,                 //选择文件后自动上传，若关闭需要自己绑定事件触发上传
            init: {
                'FilesAdded': function(up, files) {
                    plupload.each(files, function(file) {
                        // 文件添加进队列后,处理相关的事情
//                        var progress = new FileProgress(file, )
                    });
                },
                'BeforeUpload': function(up, file) {
                    // 每个文件上传前,处理相关的事情
                },
                'UploadProgress': function(up, file) {
                    // 每个文件上传时,处理相关的事情
                },
                'FileUploaded': function(up, file, info) {
                    // 每个文件上传成功后,处理相关的事情
                    // 其中 info 是文件上传成功后，服务端返回的json，形式如
                    // {
                    //    \"hash\": \"Fh8xVqod2MQ1mocfI4S4KpRL6D98\",
                    //    \"key\": \"gogopher.jpg\"
                    //  }
                    // 参考http://developer.qiniu.com/docs/v6/api/overview/up/response/simple-response.html
                    var domain = up.getOption('domain');
                    var res = $.parseJSON(info);
                    var sourceLink = domain + res.key;
                    $(\"img#preview\").attr(\"src\", sourceLink);
                    $(\"input[name='thumb']\").val(sourceLink);
//                    var html = '<li><a href=\"'+ sourceLink +'\" data-rel=\"colorbox\" class=\"cboxElement\"><img width=\"150\" height=\"150\" alt=\"150x150\" src=\"'+ sourceLink +'\"></a>'+
//                        '<div class=\"tools tools-top in\"><a href=\"#\"><i class=\"ace-icon fa fa-times red\"></i></a></div>'+
//                        '</li>';
//                    $(\"#preview-thumb\").append(html);
                },
                'Error': function(up, err, errTip) {
                    //上传出错时,处理相关的事情
                    alert(errTip);
                },
                'UploadComplete': function() {
                    //队列文件处理完毕后,处理相关的事情
                },
                'Key': function(up, file) {
                    // 若想在前端对每个文件的key进行个性化处理，可以配置该函数
                    // 该配置必须要在 unique_names: false , save_key: false 时才生效

                    var key = \"\";
                    // do something with key here
                    return key
                }
            }
        });";
            }
            //字段备注中包含"(album)" 并且 字段类型为"int(10) unsigned" 意为此处上传的相册图片名将要插入到album，并最后返回一个id，最后插入目标表
            if(strpos($column['Comment'], '(album') !== false && strpos($column['Type'], 'int(10) unsigned') !== false){
                if(empty($require_css)){
                    $require_css = '<link rel="stylesheet" href="/assets/admin/css/webuploader.css" /><link rel="stylesheet" href="/assets/admin/css/webuploader.container.css" />';
                }
                $require_js .= '<script src="/assets/admin/js/webuploader.html5only.min.js"></script>';
                $album_upload_js .= "setContainer('". $column['Field'] ."');";
                $album_upload_js .= "setFileType('". ($this->__table_name == 'store' ? $this->__table_name . '_' . (strpos($column['Field'], '_id') === false ? $column['Field'] : substr($column['Field'], 0, strpos($column['Field'], '_id'))) : $this->__table_name) ."');";
            }
            if(strpos($column['Type'], 'text') !== false && $column['Field'] !== 'description' && strpos($column['Comment'], 'resource') == false){
                $require_js .= '<script src="/assets/admin/ueditor/ueditor.config.js"></script><script src="/assets/admin/ueditor/ueditor.all.js"></script>';
                $ueditor_js .= "var ". $column['Field'] ." = UE.getEditor('". $column['Field'] ."');" . $column['Field'] . ".ready(function(){ ".$column['Field'].".setHeight(600);});";
            }
            if(strpos($column['Comment'], 'resource') !== false){
                if($resource_js_include === false){
                    $require_js .= '<script src="/assets/admin/js/fileinput.min.js"></script><script src="/assets/admin/js/fileinput_locale_zh.js"></script><link rel="stylesheet" href="/assets/admin/css/fileinput.min.css" />';
                }
            $max_file_count = (strpos($column['Comment'], 'max_file_num') !== false ? substr($column['Comment'], stripos($column['Comment'], ':') + 1, stripos($column['Comment'], '.') - strpos($column['Comment'], ':') - 1) : 1);

            if(strpos($column['Comment'], 'img') !== false){
                $allowed_extensions = "['jpg', 'gif', 'jpeg', 'png']";
            }else if(strpos($column['Comment'], 'audio') !== false){
                $allowed_extensions = "['mp3','wav']";
            }else if(strpos($column['Comment'], 'video') !== false){
                $allowed_extensions = "['mp4','avi']";
            }else{
                $allowed_extensions = "['jpg', 'gif', 'jpeg', 'png', 'mp3', 'wav', 'mp4', 'avi']";
            }
            $resource_upload_var .= "
            var control_".$column['Field']." = $('#fileupload_".$column['Field']."');
            var input_column_".$column['Field']." =$('input[name=\"".$column['Field']."\"]');
            var allowedExtensions_".$column['Field']." = ".$allowed_extensions.";
            file_input_init(control_".$column['Field'].",input_column_".$column['Field'].",$max_file_count,allowedExtensions_".$column['Field'].");
            ";
            if($resource_js_include === false){
                $resource_upload_js .= "
            var resources_preview_id_arr = [], resources_id_arr = [];
//              初始化fileinput
            function file_input_init(control,input_column,max_file_count,allowedExtensions) {
                control.fileinput({
                    language: 'zh',
                    uploadUrl: '/common/qiniu/uploadFile2Qiniu',
                    maxFileCount: max_file_count,
                    validateInitialCount: true,
                    overwriteInitial: false,
                    minImageWidth: 10,
                    minImageHeight: 10,
                    maxImageWidth: 1920,
                    maxImageHeight: 1080,
                    allowedFileExtensions: allowedExtensions,
                    uploadExtraData: {
                        file_type: '" . ($this->__table_name == 'store' ? $this->__table_name . '_' . $column['Field'] : $this->__table_name) . "'
                    }
                });
                control.on('fileuploaded', function(event, data, previewId, index) {
                    var obj = data.response;
                    if(obj.result.file == 'error'){
                        $(\".file-caption-name\").text(\"文件上传失败\").addClass('text-danger');
                        $(\".file-thumb-progress\").hide();
                        $(\".kv-upload-progress\").hide();
                        $(\".file-upload-indicator\").hide();
                        //alert(obj.result.errmsg)
                    }else{ 
                        var file = input_column.val();
                        file = file == '' || max_file_count == 1 ? obj.result.file : file + \",\" + obj.result.file;
                        input_column.val(file);
                        resources_preview_id_arr.push(previewId);
                        resources_id_arr.push(obj.result.file);
                    }
                });
               control.on('filedeleted', function (event, key) {
                    var key_arr = key.split(',');
                    var file = input_column.val();
                    var new_file = file.replace(key_arr[1], '');
                    input_column.val(new_file);
                });
                control.on('filesuccessremove', function(event, id){
                    for(var i = 0; i <= resources_preview_id_arr.length; i++){
                        if(resources_preview_id_arr[i] == id){
                            var key = resources_id_arr[i];
                            break;
                        }
                    }
                    key = '" . ($this->__table_name == 'store' ? $this->__table_name . '_' . $column['Field'] : $this->__table_name) . ",'+ key;
                    $.ajax({
                        url: \"/common/qiniu/deleteFile\",
                        type: 'post',
                        data: {key: key},
                        success: function(result){
                            if(result.result == 'error'){
                                alert('文件删除无法从七牛云删除，请联系超级管理员');
                            }else{
                                var key_arr = key.split(',');
                                var file = input_column.val();
                                var new_file = file.replace(key_arr[1], '');
                                input_column.val(new_file);
                            }
                        },
                        error: function(){
                            alert('error');
                        }
                    });
                });
            }";
            }
//            }
                $resource_js_include = true;
            }
//            var_dump($column['Comment'] . '---' . $column['Field'] . '---' . $column['Type']);
        }
        $code = ($require_js !== false ? $require_js : '') . (!empty($require_css) ? $require_css : '') . '<div class="main-content">'.
            '%    <div class="breadcrumbs" id="breadcrumbs">'.
            '%        <script type="text/javascript">try{ace.settings.check("breadcrumbs" , "fixed")}catch(e){}</script>'.
            '%%        <ul class="breadcrumb">'.
            '%            <li>'.
            '%                <i class="icon-home home-icon"></i>'.
            '%                <a href="">' . $this->__module_display_name . '</a>'.
            '%            </li>'.
            '%            <li>'.
            '%                <a href="index">' . $this->__controller_display_name . '</a>'.
            '%            </li>'.
            '%            <li class="active">' . $this->__action_display_name . '</li>'.
            '%        </ul><!-- .breadcrumb -->'.
            '%    </div>'.
            '%    <div class="page-content">'.
            '%        <div class="page-header">'.
            '%            <h1>'.
            '%                ' . $this->__controller_display_name .
            '%                <small>'.
            '%                    <i class="icon-double-angle-right"></i>'.
            '%                    '. $this->__action_display_name .
            '%                </small>'.
            '%            </h1>'.
            '%        </div>'.
            '%        <div class="row">'.
            '%            <div class="col-xs-4">'.
            '%                <?php echo $form; ?>'.
            '%            </div>'.
            '%        </div>'.
            '%        <script>' . $thumb_upload_js . $album_upload_js . $resource_upload_var . $resource_upload_js . $ueditor_js .
            '%        </script>'.
            '%    </div>'.
            '%</div>';
        return str_replace('%', "\r\n", $code);
    }
    private function __genEditHtml(){
        $ueditor_js = false;
        $album_upload_js = false;
        $thumb_upload_js = false;
        $require_css = '';
        $require_js = '';
        $resource_js_include = false;
        $resource_upload_var = '';
        $resource_upload_js = '';
        foreach ($this->__table_construct as $column){
            //字段备注中包含"(avatar)"或"(thumb)" 并且字段类型为varchar 意为保存图片文件名
            if((strpos($column['Comment'], '(thumb)') !== false || strpos($column['Comment'], '(avatar)') !== false)
                && strpos($column['Type'], 'varchar') !== false){
                $require_css = '<link rel="stylesheet" href="/assets/admin/css/webuploader.css" /><link rel="stylesheet" href="/assets/admin/css/webuploader.container.css" />';
                $require_js .= '<script src="/assets/qiniu/src/qiniu.js"></script>'.
                    '<script src="/assets/plupload/js/moxie.min.js"></script>'.
                    '<script src="/assets/plupload/js/plupload.dev.js"></script>'.
                    '<script src="/assets/admin/js/37eGoWebuploader.js"></script>';
                $thumb_upload_js = "var uploader = Qiniu.uploader({
            runtimes: 'html5',    //上传模式,依次退化
            browse_button: 'pickfiles',       //上传选择的点选按钮，**必需**
            uptoken_url: '/common/qiniu/qiniuAuth?file_type=". ($this->__table_name == 'store' ? $this->__table_name . '_' . $column['Field'] : $this->__table_name) ."',            //Ajax请求upToken的Url，**强烈建议设置**（服务端提供）
            // uptoken : '', //若未指定uptoken_url,则必须指定 uptoken ,uptoken由其他程序生成
            unique_names: true, // 默认 false，key为文件名。若开启该选项，SDK为自动生成上传成功后的key（文件名）。
            // save_key: true,   // 默认 false。若在服务端生成uptoken的上传策略中指定了 `sava_key`，则开启，SDK会忽略对key的处理
            domain: 'http://oka115078.bkt.clouddn.com/',   //bucket 域名，下载资源时用到，**必需**
            get_new_uptoken: false,  //设置上传文件的时候是否每次都重新获取新的token
            container: 'container',           //上传区域DOM ID，默认是browser_button的父元素，
            max_file_size: '3mb',           //最大文件体积限制
            flash_swf_url: 'js/plupload/Moxie.swf',  //引入flash,相对路径
            max_retries: 3,                   //上传失败最大重试次数
            dragdrop: false,                   //开启可拖曳上传
            drop_element: 'pickfiles',        //拖曳上传区域元素的ID，拖曳文件或文件夹后可触发上传
            chunk_size: '4mb',                //分块上传时，每片的体积
            auto_start: true,                 //选择文件后自动上传，若关闭需要自己绑定事件触发上传
            init: {
                'FilesAdded': function(up, files) {
                    plupload.each(files, function(file) {
                        // 文件添加进队列后,处理相关的事情
//                        var progress = new FileProgress(file, )
                    });
                },
                'BeforeUpload': function(up, file) {
                    // 每个文件上传前,处理相关的事情
                },
                'UploadProgress': function(up, file) {
                    // 每个文件上传时,处理相关的事情
                },
                'FileUploaded': function(up, file, info) {
                    // 每个文件上传成功后,处理相关的事情
                    // 其中 info 是文件上传成功后，服务端返回的json，形式如
                    // {
                    //    \"hash\": \"Fh8xVqod2MQ1mocfI4S4KpRL6D98\",
                    //    \"key\": \"gogopher.jpg\"
                    //  }
                    // 参考http://developer.qiniu.com/docs/v6/api/overview/up/response/simple-response.html
                    var domain = up.getOption('domain');
                    var res = $.parseJSON(info);
                    var sourceLink = domain + res.key;
                    $(\"img#preview\").attr(\"src\", sourceLink);
                    $(\"input[name='thumb']\").val(sourceLink);
//                    var html = '<li><a href=\"'+ sourceLink +'\" data-rel=\"colorbox\" class=\"cboxElement\"><img width=\"150\" height=\"150\" alt=\"150x150\" src=\"'+ sourceLink +'\"></a>'+
//                        '<div class=\"tools tools-top in\"><a href=\"#\"><i class=\"ace-icon fa fa-times red\"></i></a></div>'+
//                        '</li>';
//                    $(\"#preview-thumb\").append(html);
                },
                'Error': function(up, err, errTip) {
                    //上传出错时,处理相关的事情
                    alert(errTip);
                },
                'UploadComplete': function() {
                    //队列文件处理完毕后,处理相关的事情
                },
                'Key': function(up, file) {
                    // 若想在前端对每个文件的key进行个性化处理，可以配置该函数
                    // 该配置必须要在 unique_names: false , save_key: false 时才生效

                    var key = \"\";
                    // do something with key here
                    return key
                }
            }
        });";
            }
            //字段备注中包含"(album)" 并且 字段类型为"int(10) unsigned" 意为此处上传的相册图片名将要插入到album，并最后返回一个id，最后插入目标表
            if(strpos($column['Comment'], '(album') !== false && strpos($column['Type'], 'int(10) unsigned') !== false){
                if(empty($require_css)){
                    $require_css = '<link rel="stylesheet" href="/assets/admin/css/webuploader.css" /><link rel="stylesheet" href="/assets/admin/css/webuploader.container.css" />';
                }
                $require_js .= '<script src="/assets/admin/js/webuploader.html5only.min.js"></script>';
                $album_upload_js .= "setContainer('". $column['Field'] ."');";
                $album_upload_js .= "setFileType('". ($this->__table_name == 'store' ? $this->__table_name . '_' . (strpos($column['Field'], '_id') === false ? $column['Field'] : substr($column['Field'], 0, strpos($column['Field'], '_id'))) : $this->__table_name) ."');";
            }
            if(strpos($column['Type'], 'text') !== false && $column['Field'] !== 'description' && strpos($column['Comment'], 'resource') === false){
                $require_js .= '<script src="/assets/admin/ueditor/ueditor.config.js"></script><script src="/assets/admin/ueditor/ueditor.all.js"></script>';
                $ueditor_js .= "var ". $column['Field'] ." = UE.getEditor('". $column['Field'] ."');" . $column['Field'] . ".ready(function(){ ".$column['Field'].".setHeight(600);});";
            }

            if(strpos($column['Comment'], 'resource') !== false){
                if($resource_js_include === false){
                    $require_js .= '<script src="/assets/admin/js/fileinput.min.js"></script><script src="/assets/admin/js/fileinput_locale_zh.js"></script><link rel="stylesheet" href="/assets/admin/css/fileinput.min.css" />';

                }
            $max_file_count = (strpos($column['Comment'], 'max_file_num') !== false ? substr($column['Comment'], stripos($column['Comment'], ':') + 1, stripos($column['Comment'], '.') - strpos($column['Comment'], ':') - 1) : 1);

            if(strpos($column['Comment'], 'img') !== false){
                $allowed_extensions = "['jpg', 'gif', 'jpeg', 'png']";
            }else if(strpos($column['Comment'], 'audio') !== false){
                $allowed_extensions = "['mp3','wav']";
            }else if(strpos($column['Comment'], 'video') !== false){
                $allowed_extensions = "['mp4','avi']";
            }else{
                $allowed_extensions = "['jpg', 'gif', 'jpeg', 'png', 'mp3', 'wav', 'mp4', 'avi']";
            }
            $resource_upload_var .= "
            var control_".$column['Field']." = $('#fileupload_".$column['Field']."');
            var input_column_".$column['Field']." =$('input[name=\"".$column['Field']."\"]');
            var allowedExtensions_".$column['Field']." = ".$allowed_extensions.";
            file_input_init(control_".$column['Field'].",input_column_".$column['Field'].",$max_file_count,allowedExtensions_".$column['Field'].");
            ";

            if($resource_js_include === false) {
                $resource_upload_js .= "
//              初始化fileinput
            function file_input_init(control,input_column,max_file_count,allowedExtensions) {
                var resource = input_column.val();
                var resource_arr = resource.split(',');
                var key_resource = '';
                var preview_config_arr = [];
                var preview_image_arr = [];"."
                
                $.each(resource_arr, function (key, value) {
                    if (value != '' && value != '0') {
                        key_resource = value.split('.com/')[1];";
                     if(strpos($column['Comment'], 'img') !== false){
                         $resource_upload_js .= ""."
                        preview_image_arr[key] = '<img id=\"preview-url\" src=\"'+ value +'?imageView/2/w/455\" class=\"file-preview-image\">';";
                     }else if(strpos($column['Comment'], 'audio') !== false){
                         $resource_upload_js .= ""." 
                        preview_image_arr[key] = '<audio controls=\"controls\" id=\"preview-url\"  src=\"' + value + '\"></audio>';";
                     }else if(strpos($column['Comment'], 'video') !== false){
                         $resource_upload_js .= ""."
                        preview_image_arr[key] = '<video controls=\"controls\" width=\"455\" id=\"preview-url\"  src=\"' + value + '\"></video>';";
                     }else {
                        $resource_upload_js .= "
                        if(value.indexOf('mp4') >= 0 || value.indexOf('avi') >= 0){
                            "."preview_image_arr[key] = '<video controls=\"controls\" width=\"455\" id=\"preview-url\"  src=\"' + value + '\"></video>';
                        }else if(value.indexOf('mp3') >= 0 || value.indexOf('wav') >= 0){
                            preview_image_arr[key] = '<audio controls=\"controls\" id=\"preview-url\"  src=\"' + value + '\"></audio>';
                        }else if(value.indexOf('png') >= 0 || value.indexOf('jpg') >= 0 || value.indexOf('jpeg') >= 0 || value.indexOf('gif') >= 0){
                            preview_image_arr[key] = '<img id=\"preview-url\" src=\"'+ value +'?imageView/2/w/455\" class=\"file-preview-image\">';
                        }else{
                            preview_image_arr[key] = '<div class=\"file-object\" id=\"preview-url\" data-var=\"' + value + '\"></div>';
                        }";
                     }
                     $resource_upload_js .="
                        preview_config_arr[key] = {
                            caption: key_resource,
                            width: \"120px\",
                            url: \"/common/qiniu/deleteFile\",
                            key: ['" . ($this->__table_name == 'store' ? $this->__table_name . '_' . $column['Field'] : $this->__table_name) . "', value]
                        }
                    }});
                    
                 var resources_preview_id_arr = [], resources_id_arr = [];
                 
                control.fileinput({
                    language: 'zh',
                    uploadUrl: '/common/qiniu/uploadFile2Qiniu',
                    maxFileCount: max_file_count,
                    validateInitialCount: true,
                    overwriteInitial: false,
                    minImageWidth: 10,
                    minImageHeight: 10,
                    maxImageWidth: 1920,
                    maxImageHeight: 1080,
                    allowedFileExtensions: allowedExtensions,
                    uploadExtraData: {
                        file_type: '" . ($this->__table_name == 'store' ? $this->__table_name . '_' . $column['Field'] : $this->__table_name) . "'
                    },
                    initialPreview: preview_image_arr,
                    initialPreviewConfig: preview_config_arr
                });
                control.on('fileuploaded', function(event, data, previewId, index) {
                    var obj = data.response;
                    if(obj.result.file == 'error'){
                     $(\".file-caption-name\").text(\"文件上传失败\").addClass('text-danger');
                        $(\".file-thumb-progress\").hide();
                        $(\".kv-upload-progress\").hide();
                        $(\".file-upload-indicator\").hide();
                        //alert(obj.result.errmsg)
                    }else{  
                        var file = input_column.val();
                        file = file == '' || max_file_count == 1 ? obj.result.file : file + \",\" + obj.result.file;
                        input_column.val(file);
                        resources_preview_id_arr.push(previewId);
                        resources_id_arr.push(obj.result.file);
                    }
                });
                control.on('filedeleted', function (event, key) {
                    var key_arr = key.split(',');
                    var file = input_column.val();
                    var new_file = file.replace(key_arr[1], '');
                    input_column.val(new_file);
                });
                control.on('filesuccessremove', function(event, id){
                    for(var i = 0; i <= resources_preview_id_arr.length; i++){
                        if(resources_preview_id_arr[i] == id){
                            var key = resources_id_arr[i];
                            break;
                        }
                    }
                    key = '" . ($this->__table_name == 'store' ? $this->__table_name . '_' . $column['Field'] : $this->__table_name) . ",'+ key;
                    $.ajax({
                        url: \"/common/qiniu/deleteFile\",
                        type: 'post',
                        data: {key: key},
                        success: function(result){
                            if(result.result == 'error'){
                                alert('文件删除无法从七牛云删除，请联系超级管理员');
                            }else{
                                var key_arr = key.split(',');
                                var file = input_column.val();
                                var new_file = file.replace(key_arr[1], '');
                                input_column.val(new_file);
                            }
                        },
                        error: function(){
                            alert('error');
                        }
                    });
                });
            }";
            }
//            }
                $resource_js_include = true;
            }
//            var_dump($column['Comment'] . '---' . $column['Field'] . '---' . $column['Type']);
        }
        $code = ($require_js !== false ? $require_js : '') . (!empty($require_css) ? $require_css : '') . '<div class="main-content">'.
            '%    <div class="breadcrumbs" id="breadcrumbs">'.
            '%        <script type="text/javascript">try{ace.settings.check("breadcrumbs" , "fixed")}catch(e){}</script>'.
            '%%        <ul class="breadcrumb">'.
            '%            <li>'.
            '%                <i class="icon-home home-icon"></i>'.
            '%                <a href="">' . $this->__module_display_name . '</a>'.
            '%            </li>'.
            '%            <li>'.
            '%                <a href="index">' . $this->__controller_display_name . '</a>'.
            '%            </li>'.
            '%            <li class="active">' . $this->__action_display_name . '</li>'.
            '%        </ul><!-- .breadcrumb -->'.
            '%    </div>'.
            '%    <div class="page-content">'.
            '%        <div class="page-header">'.
            '%            <h1>'.
            '%                ' . $this->__controller_display_name .
            '%                <small>'.
            '%                    <i class="icon-double-angle-right"></i>'.
            '%                    '. $this->__action_display_name .
            '%                </small>'.
            '%            </h1>'.
            '%        </div>'.
            '%        <div class="row">'.
            '%            <div class="col-xs-4">'.
            '%                <?php echo $form; ?>'.
            '%            </div>'.
            '%        </div>'.
            '%        <script>' . $thumb_upload_js . $album_upload_js . $resource_upload_var . $resource_upload_js . $ueditor_js .
            '%        </script>'.
            '%    </div>'.
            '%</div>';
        return str_replace('%', "\r\n", $code);
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
        $table_prefix = substr($this->__table_name, 0, 1);
        foreach ($this->__table_construct as $column){
            $sortname = $column['Key'] == 'PRI' && $column['Field'] != 'id' && $sortname == 'id' ? $column['Field'] : $sortname;
            $edittype = strpos($column['Type'], 'varchar') !== false ?
                (substr($column['Type'], strrpos($column['Type'], '(') + 1, strrpos($column['Type'], ')') - strrpos($column['Type'], '(') - 1) > 16 ? 'textarea' : false) :
                (strpos($column['Type'], 'text') !== false ? 'texarea' : false);
            $length = strpos($column['Type'], 'varchar') !== false ? (substr($column['Type'], strrpos($column['Type'], '(') + 1, strrpos($column['Type'], ')') - strrpos($column['Type'], '(') - 1)) * 2 : '100';
            $search = !isset($foreign_column_arr[$column['Field']]) ? "true" : "false";
//            var_dump(($edittype === false ? '' : ", edittype: '" . $edittype . "'"));
            $model_arr[] = $column['Extra'] != 'auto_increment' ?
                "{name: '" . $table_prefix . "`" . $column['Field'] . "`', index: '" . $table_prefix . "`" . $column['Field'] . "`', width: " . ($length <= '55' ? '55' : $length) . ", editable: true". ($edittype === false ? '' : (", edittype: '" . $edittype . "'")) . ", search: " . $search . "}" :
                "{name: '" . $table_prefix . "`" . $column['Field'] . "`', index: '" . $table_prefix . "`" . $column['Field'] . "`', width: 55, search: ". $search . "}";
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
            "%                id: '" . $table_prefix . "_id', //相当于设置主键".
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
        $table_prefix = substr($this->__table_name, 0, 1);
        $sortname = 'id';

        foreach ($this->__table_construct as $column){
            $sortname = $column['Key'] == 'PRI' && $column['Field'] != 'id' && $sortname == 'id' ? $column['Field'] : $sortname;
            $edittype = strpos($column['Type'], 'varchar') !== false ?
                (substr($column['Type'], strrpos($column['Type'], '(') + 1, strrpos($column['Type'], ')') - strrpos($column['Type'], '(') - 1) > 16 ? 'textarea' : false) :
                (strpos($column['Type'], 'text') !== false ? 'texarea' : false);
            $length = strpos($column['Type'], 'varchar') !== false ? (substr($column['Type'], strrpos($column['Type'], '(') + 1, strrpos($column['Type'], ')') - strrpos($column['Type'], '(') - 1)) * 2 : '100';
            $search = !isset($foreign_column_arr[$column['Field']]) ? "true" : "false";
//            var_dump(($edittype === false ? '' : ", edittype: '" . $edittype . "'"));
            /*$model_arr[] = $column['Extra'] != 'auto_increment' ?*/

            $field_edit_name = '';
            $search_options = '';
            if(strrpos($column['Type'], 'tinyint') !== false || strrpos($column['Comment'], 'thumb') !== false ||(strrpos($column['Comment'], 'img') !== false && strrpos($column['Comment'], 'multiple') === false)){
                $file_name_arr = explode('_', ($column['Field']));
                foreach($file_name_arr as $k => $v){
                    $field_edit_name .=  ($k == 0 ? $v : ucfirst($v));
                }
                $field_edit_name = $field_edit_name.'Edit';
                if(strrpos($column['Type'], 'tinyint') !== false) {
                    $label_real_arr = explode(',', str_replace(['(', ')'], '', $column['Comment']));
                    foreach ($label_real_arr as $val) {
                        if (strpos($val, '默认') === false && preg_match_all("/(\\d{1})/is", $val, $num_arr) !== false) {
                            $search_options .= $num_arr[0][0] . ":'" . substr($val, stripos($val, $num_arr[0][0]) + 4) . "',";
                        }
                    }
                }
            }

            $model_arr[$column['Field']] = $column['Extra'] != 'auto_increment' ?
                "{name: '" . $table_prefix . "_" . $column['Field'] . "', index: '" . $table_prefix . "_" . $column['Field'] . "', width: " . ($length <= '55' ? '55' : $length) . ", editable: true". ($edittype === false ? '' : (", edittype: '" . $edittype . "'")) . ", search: " . $search .  (strrpos($column['Type'], 'tinyint') !== false ? (", stype: 'select', searchoptions: {value:{" . rtrim($search_options, ",")  . "}},formatter:".$field_edit_name) : '') . ((strrpos($column['Comment'], 'thumb') !== false || (strrpos($column['Comment'], 'img') !== false && strrpos($column['Comment'], 'multiple') === false)) ? (", formatter: " . $field_edit_name . "") : '') . (strrpos($column['Field'], '_at') !== false ? (", stype:'text', searchoptions: {dataInit:dateTimePicker, attr:{title:'Select Date'}}") : '')."}" :
                "{name: '" . $table_prefix . "_" . $column['Field'] . "', index: '" . $table_prefix . "_" . $column['Field'] . "', width: 55, search: ". $search . "}";
            $field_arr[] = $column['Field'];
            $comment_arr[] = (stripos($column['Comment'], '(') !== false ? strstr(substr(
                $column['Comment'],
                0,
                (stripos($column['Comment'], '.<') !== false ?
                    stripos($column['Comment'], '.<') :
                    (stripos($column['Comment'], '.{<') !== false ? stripos($column['Comment'], '.{<') : strlen($column['Comment']))
                )
            ),'(',true) : substr(
                $column['Comment'],
                0,
                (stripos($column['Comment'], '.<') !== false ?
                    stripos($column['Comment'], '.<') :
                    (stripos($column['Comment'], '.{<') !== false ? stripos($column['Comment'], '.{<') : strlen($column['Comment']))
                )
            )); /*. '[' . ($column['Type']) . ']'*/
        }
        //查找外键关系，并将关联字段赋值给对应的model
        $sql = "SELECT * FROM `foreign_relationship` WHERE `table` = '" . $this->__table_name . "'";
        $foreign_relationship = $this->_getResult($sql);
        $foreign_relationship_table_prefix = $foreign_relationship_table_prefix_match_arr = [];
        $i = $j = 1;
        $table_prefix = substr($this->__table_name, 0, 1);
        foreach ($foreign_relationship as $row => $value){
            if(preg_match_all('/<"(.*)":"(.*)">/Usi', $value['comment'], $comment_array)){
//                $comment_arr[] = $value['table'] .'表的' . $value['column'] . '字段关联' . $comment_array[1][0] . '表的' . $comment_array[2][0] . '字段';
                if(!isset($foreign_relationship_table_prefix[$value['column']])){
                    // 自己连自己
                    if($comment_array[1][0] == $this->__table_name){
                        $foreign_relationship_table_prefix[$value['column']] = substr($comment_array[1][0], 0, 1) . '_' . $i++;
                    }else{
                        // 表前缀一致
                        if(substr($comment_array[1][0], 0, 1) == $table_prefix){
                            $foreign_relationship_table_prefix[$value['column']] = substr($comment_array[1][0], 0, 1) . '_' . $j++;
                        }else{
                            $foreign_relationship_table_prefix[$value['column']] = substr($comment_array[1][0], 0, 1);
                        }
                    }
//                    $foreign_relationship_table_prefix[$value['column']] = $comment_array[1][0] != $table_name ? substr($comment_array[1][0], 0, 1) :
//                        substr($comment_array[1][0], 0, 1) . '_1';
                    $foreign_relationship_table_prefix_match_arr[$comment_array[1][0]][] = $value['column'];
                }else{
                    if(!in_array($value['column'], $foreign_relationship_table_prefix_match_arr[$comment_array[1][0]])){
                        $foreign_relationship_table_prefix_match_arr[$comment_array[1][0]][] = $value['column'];
                    }
                    $foreign_relationship_table_prefix[$value['column']] =
                        substr($comment_array[1][0], 0, 1) .
                        (count($foreign_relationship_table_prefix_match_arr[$comment_array[1][0]]) - 1 > 0 ?
                            '_' . count($foreign_relationship_table_prefix_match_arr[$comment_array[1][0]]) - 1 :
                            ''
                        );
                }
                $model_arr[$value['column']] = "{name: '" . $foreign_relationship_table_prefix[$value['column']] . '_' . $value['foreign_column'] .
                    "', index: '" . $foreign_relationship_table_prefix[$value['column']] . '_' . $value['foreign_column'] . "', width: 55, editable: false, search: true}";
            }
        }

        foreach ($model_arr as $row => $json_code){
            $model_arr[] = $json_code;
            unset($model_arr[$row]);
        }

        $url = '/' . $this->__module_name . '/' . $this->__controller_name . '/' . $this->__action_name;
        $datetime_picker_code = '';
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
            "%            colModel :" . str_replace('"', '', json_encode($model_arr, JSON_UNESCAPED_UNICODE)) . ", ".
            "%            viewrecords : true,".
            "%            rowNum: 20,".
            "%            pager : pager_selector,".
            "%            altRows: true,".
            "%            multiselect: true,".
            "%            multiboxonly: false,".
            "%            jsonReader: {".
            "%                id: '". $table_prefix ."_id', ".
            "%                root: 'data', ".
            "%                total: 'meta.total_pages', ".
            "%                page: 'meta.current_page',".
            "%                records: 'meta.total_result', ".
            "%                repeatitems: true".
            "%            },".
            "%            sortname: '". $sortname ."',".
            "%            sortorder: 'desc',".
            "%            caption: '". $this->__controller_display_name ."列表',".
            "%            loadError : function(xhr){".
            "%                alert('error');".
            "%            },".
            "%            loadComplete: function(xhr){".
            "%                console.log(JSON.stringify(xhr));".
            "%                if(xhr.errno){".
            "%                    alert(xhr.errmsg);".
            "%                }else{ ".
            "%                    var ids = $(grid_selector).jqGrid('getDataIDs');".
            "%                    for(var i = 0; i < xhr.data.length; i++){ ".
            "%                        var id = xhr.data[i]['". $table_prefix ."_id'];".
            "%                        var html = '<a href=\"" . str_replace($this->__action_name, 'edit', $url) . "?id=' + id + '\" >' + id + '</a>'; ".
            "%                        $(grid_selector).jqGrid('setRowData', ids[i], {'". $table_prefix ."_id': html});".
            "%                    }".
            "%                }".
            "%            },".
            "%            editurl: '" . str_replace($this->__action_name, 'delete', $url) . "',".
            "%            autowidth: true".
            "%        });";
        $dateTimePick = false;
        foreach ($this->__table_construct as $column) {
            $field_edit_name = '';
            $file_name_arr = explode('_', ($column['Field']));
            foreach($file_name_arr as $k => $v){
                $field_edit_name .=  ($k == 0 ? $v : ucfirst($v));
            }
            $field_edit_name = $field_edit_name.'Edit';
            $label_real_arr = explode(',', str_replace(['(', ')'], '', $column['Comment']));
            if(strrpos($column['Type'], 'tinyint') !== false){
                $code .= "%        function ".$field_edit_name."(cellvalue, options, cell ){".
                         "%           var fontColor = '';";
                foreach ($label_real_arr as $key => $val) {
                    if (strpos($val, '默认') === false && preg_match_all("/(\\d{1})/is", $val, $num_arr) !== false) {
                        $edit_num = $num_arr[0][0];
                        $edit_name = substr($val, stripos($val, $num_arr[0][0]) + 4);
                        if($key == 0){
                            $code .=  "%           var " . $column['Field'] . " = cell." . $table_prefix . "_" . $column['Field'] . ";".
                                      "%         ".
                                      "%           if(" . $column['Field'] . " == " . $edit_num . "){".
                                      "%               " . $column['Field'] . " = '" . $edit_name . "'".
                                      "%           }";
                        }else{
                            $code .=  "%           else if(" . $column['Field'] . " == " . $edit_num . "){".
                                      "%               " . $column['Field'] . " = '" . $edit_name . "'".
                                      "%           }";
                        }
                    }
                }
                $code .=   "%           return '<div '+fontColor+' >' + " . $column['Field'] . " + '</div>';".
                           "%        }";

            }else if(strrpos($column['Comment'], 'thumb') !== false || (strrpos($column['Comment'], 'img') !== false && strrpos($column['Comment'], 'multiple') === false)){
                $code .= "%        function ".$field_edit_name."(cellvalue, options, cell ){".
                         "%           var " . $column['Field'] . " = cell." . $table_prefix . "_" . $column['Field'] . ";".
                         "%         ".
                         "%           if(" . $column['Field'] . " != ''){".
                         "%               " . $column['Field'] . " = cell." . $table_prefix . "_" . $column['Field'] . "+'?imageView/2/h/75';".
                         "%           }".
                         "%           return '<div style=\"height: 75px\"><img height=\"75\" src=\"'+" . $column['Field'] . "+'\"></div>';".
                         "%        }";
            }
            if(strpos($column['Field'], '_at') && $dateTimePick == false){
                $datetime_picker_code = "%         dateTimePicker = function(elem){".
                                        "%             jQuery(elem).datetimepicker({ ".
                                        "%                   format:'yyyy-mm-dd hh:ii:ss',".
                                        "%                   language:  'zh'".
                                        "%             });".
                                        "%         };       ";
                $dateTimePick = true;
            }
        }
        $code .=  "%        /*navButtons*/".
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
            "%                afterSubmit: function(response, postData){".
            "%                     var responseText = $.parseJSON(response.responseText);".
            "%                     return responseText.message;".
            "%                },".
            "%                errorTextFormat: function(res){".
            "%                    var responseText = $.parseJSON(res.responseText);".
            "%                    var errmsg = $.parseJSON(responseText.errmsg);".
            "%                    return errmsg.message;".
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
            "%    });". $datetime_picker_code .
            "%</script>";
        return str_replace('%', "\r\n", str_replace("@", "$", $code));
    }
}