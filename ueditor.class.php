<?php
/**
 * ECJIA 文本编辑器扩展类
 */

defined('IN_ECJIA') or exit('No permission resources.');

class ueditor extends Component_Editor_Editor {
    
    private $editor_id;
    
    public function editor_settings($editor_id, $set) {
        $first_run = false;
        
        if (empty($this->first_init)) {
            if (defined('IN_ADMIN')) {
                if (is_pjax()) {
                    RC_Hook::add_action('admin_pjax_footer', array(&$this, 'editor_js'), 50);
                    RC_Hook::add_action('admin_pjax_footer', array(&$this, 'enqueue_scripts'), 1);
                } else {
                    RC_Hook::add_action('admin_footer', array(&$this, 'editor_js'), 50);
                    RC_Hook::add_action('admin_footer', array(&$this, 'enqueue_scripts'), 1);
                }
            } else {
                RC_Hook::add_action('front_print_footer_scripts', array(&$this, 'editor_js'), 50);
                RC_Hook::add_action('front_print_footer_scripts', array(&$this, 'enqueue_scripts'), 1);
            }
            
            $this->editor_id = $editor_id;
        }
    }
    
    
    public function enqueue_scripts()
    {
        
    }
    
    public function editor_js()
    {
        echo $this->create($this->editor_id, '');
    }

    /**
     * 创建编辑器
     * 
     * @param   string $input_name
     * @param   string $input_value
     * @return  string
     */
    public function create($input_name, $input_value)
    {
    	$input_value = htmlspecialchars($input_value);
    	$lang = 'zh-cn';
    	$home_url = RC_Plugin::plugins_url('/', __FILE__);
    	$serverUrl = RC_Uri::url('api/api/plugin', 'handle=ueditor/ueditorserver');
    	$time = time();
    	$item = htmlspecialchars($input_name);

    	$editor = <<<STR
    			<input type="hidden" id="{$input_name}" name="{$input_name}" value="{$input_value}" />
				<script type="text/javascript" >
					window.UEDITOR_HOME_URL =  '$home_url';
				</script>
				<script type="text/plain" name="content" id="container"></script>
				<script type="text/javascript" src="{$home_url}ueditor.config.js?v={$time}>"></script>
				<script type="text/javascript" >
// 					window.UEDITOR_CONFIG.serverUrl = '{$serverUrl}';
				        
				        //工具栏上的所有的功能按钮和下拉框，可以在new编辑器的实例时选择自己需要的从新定义
// 				    window.UEDITOR_CONFIG.toolbars = [
// 				            ['fullscreen', 'source', '|', 'undo', 'redo', '|',
// 				                'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',
// 				                'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
// 				                'customstyle', 'paragraph', '|', 'fontfamily', 'fontsize', '|',
// 				                'directionalityltr', 'directionalityrtl', 'indent', '|',
// 				                'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|',
// 				                'link', 'unlink', 'anchor', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
// 				                'inserttable', 'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols', 'charts',
// 				                'insertimage', 'emotion', 'scrawl', 'insertvideo', 'attachment', 'map', 'insertframe', 'pagebreak', 'template', 'insertcode', '|',
// 				                'horizontal', 'date', 'time', 'spechars', 'wordimage', '|',
// 				                'print', 'preview', 'searchreplace', 'drafts', 'help']
// 				        ];
				        //, 'gmap'
// 					// window.UEDITOR_CONFIG.scaleEnabled = 1;
// 					// window.UEDITOR_CONFIG.initialFrameWidth = 1000; //初始化编辑器宽度,默认1000
// 				    window.UEDITOR_CONFIG.initialFrameHeight = 450; //初始化编辑器高度,默认320
// 				    window.UEDITOR_CONFIG.autoHeightEnabled = false; //自动长高
// 				    window.UEDITOR_CONFIG.allowDivTransToP = false; //禁止DIV自动转换成p
//         			window.UEDITOR_CONFIG.autoFloatEnabled = false; //是否保持toolbar的位置不动,默认true
//         			window.UEDITOR_CONFIG.topOffset = 40;
//         			window.UEDITOR_CONFIG.toolbarTopOffset = 50;
        			
				</script>
				<script type="text/javascript" src="{$home_url}ueditor.all.min.js"></script>
				<script type="text/javascript" src="{$home_url}lang/{$lang}/{$lang}.js"></script>
				<script type="text/javascript">
					var cBox = $('#$item');
					var editor = UE.getEditor('$input_name',{
                		toolbars: [
							['fullscreen', 'source', '|', 'undo', 'redo', '|',
			                'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',
			                'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
			                'customstyle', 'paragraph', '|', 'fontfamily', 'fontsize', '|',
			                'directionalityltr', 'directionalityrtl', 'indent', '|',
			                'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|',
			                'link', 'unlink', 'anchor', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
			                'inserttable', 'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols', 'charts',
			                'insertimage', 'emotion', 'scrawl', 'insertvideo', 'attachment', 'map', 'insertframe', 'pagebreak', 'template', 'insertcode', '|',
			                'horizontal', 'date', 'time', 'spechars', 'wordimage', '|',
			                'print', 'preview', 'searchreplace', 'drafts', 'help']
					    ],
						serverUrl : '{$serverUrl}',
// 						initialFrameHeight : 450,
						autoHeightEnabled : false,
						allowDivTransToP : false,
						autoFloatEnabled : false,
						topOffset : 40,
						toolbarTopOffset : 0
    				});
					editor.addListener('ready', function() {
						var content = cBox.val();
						editor.setContent(content);
					});
					editor.addListener("contentChange", function(){setSync()});//触发同步
					window.setInterval("setSync()",1000);//自动同步
					function setSync(){
					var content = editor.getContent();
					cBox.val(content);
				}
				</script>
STR;
        return $editor;
    }
}

// end