<?php
return array (
  'title' => 
  array (
    'fieldid' => '117',
    'modelid' => '14',
    'siteid' => '1',
    'field' => 'title',
    'name' => '项目名称',
    'tips' => '',
    'css' => 'inputtitle',
    'minlength' => '1',
    'maxlength' => '200',
    'pattern' => '',
    'errortips' => '请填写项目名称',
    'formtype' => 'title',
    'setting' => '',
    'formattribute' => '',
    'unsetgroupids' => '',
    'unsetroleids' => '',
    'iscore' => '0',
    'issystem' => '1',
    'isunique' => '0',
    'isbase' => '1',
    'issearch' => '1',
    'isadd' => '1',
    'isfulltext' => '1',
    'isposition' => '1',
    'listorder' => '1',
    'disabled' => '0',
    'isomnipotent' => '0',
  ),
  'pro_addr' => 
  array (
    'fieldid' => '183',
    'modelid' => '14',
    'siteid' => '1',
    'field' => 'pro_addr',
    'name' => '建设地点',
    'tips' => '',
    'css' => '',
    'minlength' => '1',
    'maxlength' => '100',
    'pattern' => '',
    'errortips' => '请填写项目地点',
    'formtype' => 'text',
    'setting' => 'array (
  \'size\' => \'50\',
  \'defaultvalue\' => \'\',
  \'ispassword\' => \'0\',
)',
    'formattribute' => '',
    'unsetgroupids' => '',
    'unsetroleids' => '',
    'iscore' => '0',
    'issystem' => '0',
    'isunique' => '0',
    'isbase' => '1',
    'issearch' => '0',
    'isadd' => '1',
    'isfulltext' => '1',
    'isposition' => '0',
    'listorder' => '2',
    'disabled' => '0',
    'isomnipotent' => '0',
    'size' => '50',
    'defaultvalue' => '',
    'ispassword' => '0',
  ),
  'pro_fund' => 
  array (
    'fieldid' => '215',
    'modelid' => '14',
    'siteid' => '1',
    'field' => 'pro_fund',
    'name' => '总投资',
    'tips' => '万元',
    'css' => '',
    'minlength' => '1',
    'maxlength' => '100',
    'pattern' => '/^[0-9.-]+$/',
    'errortips' => '请填写项目总投资',
    'formtype' => 'number',
    'setting' => 'array (\'minnumber\' => \'0\',\'maxnumber\' => \'10\',\'decimaldigits\' => \'0\',\'size\' => \'15\',\'defaultvalue\' => \'\',)',
    'formattribute' => '',
    'unsetgroupids' => '',
    'unsetroleids' => '',
    'iscore' => '0',
    'issystem' => '0',
    'isunique' => '0',
    'isbase' => '1',
    'issearch' => '0',
    'isadd' => '1',
    'isfulltext' => '0',
    'isposition' => '0',
    'listorder' => '3',
    'disabled' => '0',
    'isomnipotent' => '0',
    'minnumber' => '0',
    'maxnumber' => '10',
    'decimaldigits' => '0',
    'size' => '15',
    'defaultvalue' => '',
  ),
  'pro_type' => 
  array (
    'fieldid' => '329',
    'modelid' => '14',
    'siteid' => '1',
    'field' => 'pro_type',
    'name' => '项目类别',
    'tips' => '',
    'css' => '',
    'minlength' => '1',
    'maxlength' => '100',
    'pattern' => '/^[0-9-]+$/',
    'errortips' => '请填写项目类别',
    'formtype' => 'linkage',
    'setting' => 'array (
  \'linkageid\' => \'3381\',
  \'showtype\' => \'2\',
  \'space\' => \'\',
  \'filtertype\' => \'0\',
)',
    'formattribute' => '',
    'unsetgroupids' => '',
    'unsetroleids' => '',
    'iscore' => '0',
    'issystem' => '1',
    'isunique' => '0',
    'isbase' => '1',
    'issearch' => '0',
    'isadd' => '1',
    'isfulltext' => '0',
    'isposition' => '0',
    'listorder' => '6',
    'disabled' => '0',
    'isomnipotent' => '0',
    'linkageid' => '3381',
    'showtype' => '2',
    'space' => '',
    'filtertype' => '0',
  ),
  'cy_type' => 
  array (
    'fieldid' => '330',
    'modelid' => '14',
    'siteid' => '1',
    'field' => 'cy_type',
    'name' => '产业类别',
    'tips' => '',
    'css' => '',
    'minlength' => '1',
    'maxlength' => '100',
    'pattern' => '',
    'errortips' => '请填写产业类别',
    'formtype' => 'linkage',
    'setting' => 'array (
  \'linkageid\' => \'3387\',
  \'showtype\' => \'2\',
  \'space\' => \'\',
  \'filtertype\' => \'0\',
)',
    'formattribute' => '',
    'unsetgroupids' => '',
    'unsetroleids' => '',
    'iscore' => '0',
    'issystem' => '1',
    'isunique' => '0',
    'isbase' => '1',
    'issearch' => '0',
    'isadd' => '1',
    'isfulltext' => '0',
    'isposition' => '0',
    'listorder' => '8',
    'disabled' => '0',
    'isomnipotent' => '0',
    'linkageid' => '3387',
    'showtype' => '2',
    'space' => '',
    'filtertype' => '0',
  ),
  'pro_nature' => 
  array (
    'fieldid' => '189',
    'modelid' => '14',
    'siteid' => '1',
    'field' => 'pro_nature',
    'name' => '项目性质',
    'tips' => '',
    'css' => '',
    'minlength' => '1',
    'maxlength' => '100',
    'pattern' => '/^[0-9.-]+$/',
    'errortips' => '请填写项目性质',
    'formtype' => 'box',
    'setting' => 'array (
  \'options\' => \'新建|1
续建|2
预备|5
其他|6\',
  \'boxtype\' => \'radio\',
  \'fieldtype\' => \'varchar\',
  \'minnumber\' => \'1\',
  \'width\' => \'50\',
  \'size\' => \'1\',
  \'defaultvalue\' => \'\',
  \'outputtype\' => \'1\',
  \'filtertype\' => \'0\',
)',
    'formattribute' => '',
    'unsetgroupids' => '',
    'unsetroleids' => '',
    'iscore' => '0',
    'issystem' => '0',
    'isunique' => '0',
    'isbase' => '1',
    'issearch' => '0',
    'isadd' => '1',
    'isfulltext' => '0',
    'isposition' => '0',
    'listorder' => '10',
    'disabled' => '0',
    'isomnipotent' => '0',
    'options' => '新建|1
续建|2
预备|5
其他|6',
    'boxtype' => 'radio',
    'fieldtype' => 'varchar',
    'minnumber' => '1',
    'width' => '50',
    'size' => '1',
    'defaultvalue' => '',
    'outputtype' => '1',
    'filtertype' => '0',
  ),
  'pro_content' => 
  array (
    'fieldid' => '196',
    'modelid' => '14',
    'siteid' => '1',
    'field' => 'pro_content',
    'name' => '建设内容',
    'tips' => '50字以上，5000字以内',
    'css' => '',
    'minlength' => '50',
    'maxlength' => '5000',
    'pattern' => '',
    'errortips' => '请填写项目建设内容',
    'formtype' => 'textarea',
    'setting' => 'array (
  \'width\' => \'100\',
  \'height\' => \'150\',
  \'defaultvalue\' => \'\',
  \'enablehtml\' => \'0\',
)',
    'formattribute' => '',
    'unsetgroupids' => '',
    'unsetroleids' => '',
    'iscore' => '0',
    'issystem' => '0',
    'isunique' => '0',
    'isbase' => '1',
    'issearch' => '0',
    'isadd' => '1',
    'isfulltext' => '1',
    'isposition' => '0',
    'listorder' => '12',
    'disabled' => '0',
    'isomnipotent' => '0',
    'width' => '100',
    'height' => '150',
    'defaultvalue' => '',
    'enablehtml' => '0',
  ),
  'contact_name' => 
  array (
    'fieldid' => '198',
    'modelid' => '14',
    'siteid' => '1',
    'field' => 'contact_name',
    'name' => '联系人',
    'tips' => '',
    'css' => '',
    'minlength' => '1',
    'maxlength' => '100',
    'pattern' => '',
    'errortips' => '请填写联系人',
    'formtype' => 'text',
    'setting' => 'array (
  \'size\' => \'15\',
  \'defaultvalue\' => \'\',
  \'ispassword\' => \'0\',
)',
    'formattribute' => '',
    'unsetgroupids' => '',
    'unsetroleids' => '',
    'iscore' => '0',
    'issystem' => '0',
    'isunique' => '0',
    'isbase' => '1',
    'issearch' => '0',
    'isadd' => '1',
    'isfulltext' => '1',
    'isposition' => '0',
    'listorder' => '14',
    'disabled' => '0',
    'isomnipotent' => '0',
    'size' => '15',
    'defaultvalue' => '',
    'ispassword' => '0',
  ),
  'contact_tel' => 
  array (
    'fieldid' => '202',
    'modelid' => '14',
    'siteid' => '1',
    'field' => 'contact_tel',
    'name' => '联系电话',
    'tips' => '',
    'css' => '',
    'minlength' => '0',
    'maxlength' => '100',
    'pattern' => '/(^[0-9-]{6,13})|(^(1)[0-9]{10})$/',
    'errortips' => '请填写联系电话',
    'formtype' => 'text',
    'setting' => 'array (
  \'size\' => \'15\',
  \'defaultvalue\' => \'\',
  \'ispassword\' => \'0\',
)',
    'formattribute' => '',
    'unsetgroupids' => '',
    'unsetroleids' => '',
    'iscore' => '0',
    'issystem' => '0',
    'isunique' => '0',
    'isbase' => '1',
    'issearch' => '0',
    'isadd' => '1',
    'isfulltext' => '1',
    'isposition' => '0',
    'listorder' => '16',
    'disabled' => '0',
    'isomnipotent' => '0',
    'size' => '15',
    'defaultvalue' => '',
    'ispassword' => '0',
  ),
  'taxation_add' => 
  array (
    'fieldid' => '212',
    'modelid' => '14',
    'siteid' => '1',
    'field' => 'taxation_add',
    'name' => '达产后新增利税',
    'tips' => '万元',
    'css' => '',
    'minlength' => '0',
    'maxlength' => '100',
    'pattern' => '/^[0-9.-]+$/',
    'errortips' => '请填写达产后新增利税',
    'formtype' => 'number',
    'setting' => 'array (\'minnumber\' => \'0\',\'maxnumber\' => \'10\',\'decimaldigits\' => \'0\',\'size\' => \'15\',\'defaultvalue\' => \'\',)',
    'formattribute' => '',
    'unsetgroupids' => '',
    'unsetroleids' => '',
    'iscore' => '0',
    'issystem' => '0',
    'isunique' => '0',
    'isbase' => '1',
    'issearch' => '0',
    'isadd' => '1',
    'isfulltext' => '0',
    'isposition' => '0',
    'listorder' => '18',
    'disabled' => '0',
    'isomnipotent' => '0',
    'minnumber' => '0',
    'maxnumber' => '10',
    'decimaldigits' => '0',
    'size' => '15',
    'defaultvalue' => '',
  ),
  'value_add' => 
  array (
    'fieldid' => '211',
    'modelid' => '14',
    'siteid' => '1',
    'field' => 'value_add',
    'name' => '达产后新增产值',
    'tips' => '万元',
    'css' => '',
    'minlength' => '0',
    'maxlength' => '100',
    'pattern' => '/^[0-9.-]+$/',
    'errortips' => '请填写达产后新增产值',
    'formtype' => 'number',
    'setting' => 'array (\'minnumber\' => \'0\',\'maxnumber\' => \'10\',\'decimaldigits\' => \'0\',\'size\' => \'15\',\'defaultvalue\' => \'\',)',
    'formattribute' => '',
    'unsetgroupids' => '',
    'unsetroleids' => '',
    'iscore' => '0',
    'issystem' => '0',
    'isunique' => '0',
    'isbase' => '1',
    'issearch' => '0',
    'isadd' => '1',
    'isfulltext' => '0',
    'isposition' => '0',
    'listorder' => '20',
    'disabled' => '0',
    'isomnipotent' => '0',
    'minnumber' => '0',
    'maxnumber' => '10',
    'decimaldigits' => '0',
    'size' => '15',
    'defaultvalue' => '',
  ),
  'start_time' => 
  array (
    'fieldid' => '213',
    'modelid' => '14',
    'siteid' => '1',
    'field' => 'start_time',
    'name' => '开工时间',
    'tips' => '',
    'css' => '',
    'minlength' => '0',
    'maxlength' => '100',
    'pattern' => '',
    'errortips' => '请填写开工时间',
    'formtype' => 'datetime',
    'setting' => 'array (
  \'fieldtype\' => \'date\',
  \'format\' => \'Y-m-d Ah:i:s\',
  \'defaulttype\' => \'0\',
)',
    'formattribute' => '',
    'unsetgroupids' => '',
    'unsetroleids' => '',
    'iscore' => '0',
    'issystem' => '0',
    'isunique' => '0',
    'isbase' => '1',
    'issearch' => '0',
    'isadd' => '1',
    'isfulltext' => '0',
    'isposition' => '0',
    'listorder' => '22',
    'disabled' => '0',
    'isomnipotent' => '0',
    'fieldtype' => 'date',
    'format' => 'Y-m-d Ah:i:s',
    'defaulttype' => '0',
  ),
  'end_time' => 
  array (
    'fieldid' => '214',
    'modelid' => '14',
    'siteid' => '1',
    'field' => 'end_time',
    'name' => '竣工时间',
    'tips' => '',
    'css' => '',
    'minlength' => '0',
    'maxlength' => '100',
    'pattern' => '',
    'errortips' => '请填写竣工时间',
    'formtype' => 'datetime',
    'setting' => 'array (
  \'fieldtype\' => \'date\',
  \'format\' => \'Y-m-d Ah:i:s\',
  \'defaulttype\' => \'0\',
)',
    'formattribute' => '',
    'unsetgroupids' => '',
    'unsetroleids' => '',
    'iscore' => '0',
    'issystem' => '0',
    'isunique' => '0',
    'isbase' => '1',
    'issearch' => '0',
    'isadd' => '1',
    'isfulltext' => '0',
    'isposition' => '0',
    'listorder' => '24',
    'disabled' => '0',
    'isomnipotent' => '0',
    'fieldtype' => 'date',
    'format' => 'Y-m-d Ah:i:s',
    'defaulttype' => '0',
  ),
  'county_opinion' => 
  array (
    'fieldid' => '224',
    'modelid' => '14',
    'siteid' => '1',
    'field' => 'county_opinion',
    'name' => '区县（市）级审核意见',
    'tips' => '',
    'css' => '',
    'minlength' => '0',
    'maxlength' => '100',
    'pattern' => '',
    'errortips' => '请填写区县（市）级审核意见',
    'formtype' => 'textarea',
    'setting' => 'array (
  \'width\' => \'100\',
  \'height\' => \'100\',
  \'defaultvalue\' => \'\',
  \'enablehtml\' => \'0\',
)',
    'formattribute' => '',
    'unsetgroupids' => '',
    'unsetroleids' => '',
    'iscore' => '0',
    'issystem' => '0',
    'isunique' => '0',
    'isbase' => '1',
    'issearch' => '0',
    'isadd' => '0',
    'isfulltext' => '1',
    'isposition' => '0',
    'listorder' => '44',
    'disabled' => '0',
    'isomnipotent' => '0',
    'width' => '100',
    'height' => '100',
    'defaultvalue' => '',
    'enablehtml' => '0',
  ),
  'city_opinion' => 
  array (
    'fieldid' => '225',
    'modelid' => '14',
    'siteid' => '1',
    'field' => 'city_opinion',
    'name' => '市级审核意见',
    'tips' => '',
    'css' => '',
    'minlength' => '0',
    'maxlength' => '100',
    'pattern' => '',
    'errortips' => '请填写市级审核意见',
    'formtype' => 'textarea',
    'setting' => 'array (
  \'width\' => \'100\',
  \'height\' => \'100\',
  \'defaultvalue\' => \'\',
  \'enablehtml\' => \'0\',
)',
    'formattribute' => '',
    'unsetgroupids' => '',
    'unsetroleids' => '9',
    'iscore' => '0',
    'issystem' => '0',
    'isunique' => '0',
    'isbase' => '1',
    'issearch' => '0',
    'isadd' => '0',
    'isfulltext' => '1',
    'isposition' => '0',
    'listorder' => '46',
    'disabled' => '0',
    'isomnipotent' => '0',
    'width' => '100',
    'height' => '100',
    'defaultvalue' => '',
    'enablehtml' => '0',
  ),
  'url' => 
  array (
    'fieldid' => '128',
    'modelid' => '14',
    'siteid' => '1',
    'field' => 'url',
    'name' => 'URL',
    'tips' => '',
    'css' => '',
    'minlength' => '0',
    'maxlength' => '100',
    'pattern' => '',
    'errortips' => '请填写URL',
    'formtype' => 'text',
    'setting' => '',
    'formattribute' => '',
    'unsetgroupids' => '',
    'unsetroleids' => '',
    'iscore' => '1',
    'issystem' => '1',
    'isunique' => '0',
    'isbase' => '1',
    'issearch' => '0',
    'isadd' => '0',
    'isfulltext' => '0',
    'isposition' => '0',
    'listorder' => '50',
    'disabled' => '0',
    'isomnipotent' => '0',
  ),
  'pro_imager' => 
  array (
    'fieldid' => '385',
    'modelid' => '14',
    'siteid' => '1',
    'field' => 'pro_imager',
    'name' => '项目图片',
    'tips' => '',
    'css' => '',
    'minlength' => '0',
    'maxlength' => '100',
    'pattern' => '',
    'errortips' => '请填写项目图片',
    'formtype' => 'images',
    'setting' => 'array (
  \'upload_allowext\' => \'gif|jpg|jpeg|png|bmp\',
  \'isselectimage\' => \'0\',
  \'upload_number\' => \'10\',
)',
    'formattribute' => '',
    'unsetgroupids' => '',
    'unsetroleids' => '',
    'iscore' => '0',
    'issystem' => '0',
    'isunique' => '0',
    'isbase' => '1',
    'issearch' => '0',
    'isadd' => '1',
    'isfulltext' => '0',
    'isposition' => '0',
    'listorder' => '50',
    'disabled' => '0',
    'isomnipotent' => '0',
    'upload_allowext' => 'gif|jpg|jpeg|png|bmp',
    'isselectimage' => '0',
    'upload_number' => '10',
  ),
  'listorder' => 
  array (
    'fieldid' => '129',
    'modelid' => '14',
    'siteid' => '1',
    'field' => 'listorder',
    'name' => '排序',
    'tips' => '',
    'css' => '',
    'minlength' => '0',
    'maxlength' => '6',
    'pattern' => '',
    'errortips' => '请填写排序',
    'formtype' => 'number',
    'setting' => '',
    'formattribute' => '',
    'unsetgroupids' => '',
    'unsetroleids' => '',
    'iscore' => '1',
    'issystem' => '1',
    'isunique' => '0',
    'isbase' => '1',
    'issearch' => '0',
    'isadd' => '0',
    'isfulltext' => '0',
    'isposition' => '0',
    'listorder' => '51',
    'disabled' => '0',
    'isomnipotent' => '0',
  ),
  'template' => 
  array (
    'fieldid' => '130',
    'modelid' => '14',
    'siteid' => '1',
    'field' => 'template',
    'name' => '内容页模板',
    'tips' => '',
    'css' => '',
    'minlength' => '0',
    'maxlength' => '30',
    'pattern' => '',
    'errortips' => '请填写内容页模板',
    'formtype' => 'template',
    'setting' => 'array (
  \'size\' => \'\',
  \'defaultvalue\' => \'\',
)',
    'formattribute' => '',
    'unsetgroupids' => '-99',
    'unsetroleids' => '-99',
    'iscore' => '0',
    'issystem' => '0',
    'isunique' => '0',
    'isbase' => '0',
    'issearch' => '0',
    'isadd' => '0',
    'isfulltext' => '0',
    'isposition' => '0',
    'listorder' => '53',
    'disabled' => '0',
    'isomnipotent' => '0',
    'size' => '',
    'defaultvalue' => '',
  ),
  'status' => 
  array (
    'fieldid' => '132',
    'modelid' => '14',
    'siteid' => '1',
    'field' => 'status',
    'name' => '状态',
    'tips' => '',
    'css' => '',
    'minlength' => '0',
    'maxlength' => '2',
    'pattern' => '',
    'errortips' => '请填写状态',
    'formtype' => 'box',
    'setting' => '',
    'formattribute' => '',
    'unsetgroupids' => '',
    'unsetroleids' => '',
    'iscore' => '1',
    'issystem' => '1',
    'isunique' => '0',
    'isbase' => '1',
    'issearch' => '0',
    'isadd' => '0',
    'isfulltext' => '0',
    'isposition' => '0',
    'listorder' => '55',
    'disabled' => '0',
    'isomnipotent' => '0',
  ),
  'username' => 
  array (
    'fieldid' => '134',
    'modelid' => '14',
    'siteid' => '1',
    'field' => 'username',
    'name' => '用户名',
    'tips' => '',
    'css' => '',
    'minlength' => '0',
    'maxlength' => '20',
    'pattern' => '',
    'errortips' => '请填写用户名',
    'formtype' => 'text',
    'setting' => '',
    'formattribute' => '',
    'unsetgroupids' => '',
    'unsetroleids' => '',
    'iscore' => '1',
    'issystem' => '1',
    'isunique' => '0',
    'isbase' => '1',
    'issearch' => '0',
    'isadd' => '0',
    'isfulltext' => '0',
    'isposition' => '0',
    'listorder' => '98',
    'disabled' => '0',
    'isomnipotent' => '0',
  ),
  'description' => 
  array (
    'fieldid' => '119',
    'modelid' => '14',
    'siteid' => '1',
    'field' => 'description',
    'name' => '摘要',
    'tips' => '',
    'css' => '',
    'minlength' => '0',
    'maxlength' => '255',
    'pattern' => '',
    'errortips' => '请填写摘要',
    'formtype' => 'textarea',
    'setting' => 'array (
  \'width\' => \'98\',
  \'height\' => \'46\',
  \'defaultvalue\' => \'\',
  \'enablehtml\' => \'0\',
)',
    'formattribute' => '',
    'unsetgroupids' => '',
    'unsetroleids' => '',
    'iscore' => '0',
    'issystem' => '1',
    'isunique' => '0',
    'isbase' => '1',
    'issearch' => '0',
    'isadd' => '1',
    'isfulltext' => '1',
    'isposition' => '1',
    'listorder' => '133',
    'disabled' => '0',
    'isomnipotent' => '0',
    'width' => '98',
    'height' => '46',
    'defaultvalue' => '',
    'enablehtml' => '0',
  ),
  'updatetime' => 
  array (
    'fieldid' => '120',
    'modelid' => '14',
    'siteid' => '1',
    'field' => 'updatetime',
    'name' => '更新时间',
    'tips' => '',
    'css' => '',
    'minlength' => '0',
    'maxlength' => '100',
    'pattern' => '',
    'errortips' => '请填写更新时间',
    'formtype' => 'datetime',
    'setting' => 'array (
  \'dateformat\' => \'int\',
  \'format\' => \'Y-m-d H:i:s\',
  \'defaulttype\' => \'1\',
  \'defaultvalue\' => \'\',
)',
    'formattribute' => '',
    'unsetgroupids' => '',
    'unsetroleids' => '',
    'iscore' => '1',
    'issystem' => '1',
    'isunique' => '0',
    'isbase' => '1',
    'issearch' => '0',
    'isadd' => '0',
    'isfulltext' => '0',
    'isposition' => '0',
    'listorder' => '134',
    'disabled' => '0',
    'isomnipotent' => '0',
    'dateformat' => 'int',
    'format' => 'Y-m-d H:i:s',
    'defaulttype' => '1',
    'defaultvalue' => '',
  ),
  'inputtime' => 
  array (
    'fieldid' => '125',
    'modelid' => '14',
    'siteid' => '1',
    'field' => 'inputtime',
    'name' => '发布时间',
    'tips' => '',
    'css' => '',
    'minlength' => '0',
    'maxlength' => '100',
    'pattern' => '',
    'errortips' => '请填写发布时间',
    'formtype' => 'datetime',
    'setting' => 'array (
  \'fieldtype\' => \'int\',
  \'format\' => \'Y-m-d H:i:s\',
  \'defaulttype\' => \'0\',
)',
    'formattribute' => '',
    'unsetgroupids' => '',
    'unsetroleids' => '',
    'iscore' => '0',
    'issystem' => '1',
    'isunique' => '0',
    'isbase' => '0',
    'issearch' => '0',
    'isadd' => '0',
    'isfulltext' => '0',
    'isposition' => '1',
    'listorder' => '142',
    'disabled' => '0',
    'isomnipotent' => '0',
    'fieldtype' => 'int',
    'format' => 'Y-m-d H:i:s',
    'defaulttype' => '0',
  ),
  'posids' => 
  array (
    'fieldid' => '126',
    'modelid' => '14',
    'siteid' => '1',
    'field' => 'posids',
    'name' => '推荐',
    'tips' => '',
    'css' => '',
    'minlength' => '0',
    'maxlength' => '100',
    'pattern' => '',
    'errortips' => '请填写推荐',
    'formtype' => 'posid',
    'setting' => 'array (
  \'width\' => \'125\',
  \'defaultvalue\' => \'\',
)',
    'formattribute' => '',
    'unsetgroupids' => '',
    'unsetroleids' => '',
    'iscore' => '0',
    'issystem' => '1',
    'isunique' => '0',
    'isbase' => '1',
    'issearch' => '0',
    'isadd' => '0',
    'isfulltext' => '0',
    'isposition' => '0',
    'listorder' => '143',
    'disabled' => '0',
    'isomnipotent' => '0',
    'width' => '125',
    'defaultvalue' => '',
  ),
  'catid' => 
  array (
    'fieldid' => '115',
    'modelid' => '14',
    'siteid' => '1',
    'field' => 'catid',
    'name' => '栏目',
    'tips' => '',
    'css' => '',
    'minlength' => '1',
    'maxlength' => '6',
    'pattern' => '/^[0-9]{1,6}$/',
    'errortips' => '请填写栏目',
    'formtype' => 'catid',
    'setting' => 'array (
  \'defaultvalue\' => \'\',
)',
    'formattribute' => '',
    'unsetgroupids' => '-99',
    'unsetroleids' => '-99',
    'iscore' => '0',
    'issystem' => '1',
    'isunique' => '0',
    'isbase' => '1',
    'issearch' => '1',
    'isadd' => '1',
    'isfulltext' => '0',
    'isposition' => '0',
    'listorder' => '333',
    'disabled' => '0',
    'isomnipotent' => '0',
    'defaultvalue' => '',
  ),
);
?>