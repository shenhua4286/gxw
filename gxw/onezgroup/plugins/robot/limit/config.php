<?php
$Con=array(
  'name'=>'������Ϣ���Ա',#�����˳ƺ�
  'readme'=>'����������',#�����˼��
  'style'=>'color:red',
  'tip'=>'<font color=#ff00ff>����������</font>',#����������ʾ��
  'grade'=>1,#����Ȩ�ޡ�1,������ 2,��ͨ����Ա 3,��������Ա
  'method'=>array(3,5),#���÷�ʽ��1,��¼ǰ���� 2,�����Ƿ��¼������ 3,��Ⱥ��Ա�б��� 4,����ҳ�Ķ��������˵���ʾ 5,����Ⱥ����Ϣ�����ظ���Ӧ��ָ��
  'myface'=>0,#�Ƿ���ʾ�û�ͷ��(�ڵ�¼ǰ������ͷ��)
  'theme'=>'',#���ʹ�ò�ͬ�ķ����棬���ڴ˸���

  'tip'=>'������ʹ���˲�ǡ���Ĵ���ѱ�����Ա���������!',#�߳��û�ǰ����ʾ��
);
///////////////////////////////////////////////////////
//�������Ĵ����б���ÿ����дһ��
$BadWords=<<<ONEZ

��
���

ONEZ;
//���ϡ��߳�������ʱ���е�JS����(�﷨������ȷ)
$jsCode=<<<ONEZ

alert('$Con[tip]');
top.location.href='http://www.onez.cn';

ONEZ;
?>