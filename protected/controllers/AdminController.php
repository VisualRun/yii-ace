<?php

class AdminController extends Controller
{

    public function init()
    {
        parent::init();
    }

	public function actionDeptment()
	{
        $this->menu_nav = array(
                array(
                    'value'=>'组织中心',
                ),
            );

		$this->pageTitle = '部门管理';
        $model = new Deptment();
        $model->unsetAttributes();
        if(isset($_GET)&&!empty($_GET))
            $model->attributes=$_GET;
		$this->render('deptment',array('model'=>$model));
	}

	public function actionWorkplace()
	{
		$this->pageTitle = '岗位管理';
        $model = new Workplace();
        $model->unsetAttributes();
        if(isset($_GET)&&!empty($_GET))
            $model->attributes=$_GET;
		$this->render('workplace',array('model'=>$model));
	}

	public function actionUser()
	{
		$this->pageTitle = '员工管理';
        $model = new User();
        $model->unsetAttributes();
        if(isset($_GET)&&!empty($_GET))
            $model->attributes=$_GET;
		$this->render('user',array('model'=>$model));
	}

    public function actionPoint(){
        $this->page_css = array(
            'jquery-ui.custom.min.css',
            'datepicker.css',
            );

        $this->page_js = array(
            'jquery-ui.custom.min.js',
            'jquery.ui.touch-punch.min.js',
            'date-time/bootstrap-datepicker.min.js',
            'date-time/locales/bootstrap-datepicker.zh-CN.js',
            );
        $this->page_script = <<<EOD
<script type="text/javascript">
    $('.date-picker').datepicker({
        autoclose: true,
        todayHighlight: true,
        language: 'zh-CN'
    })
</script>
EOD;



        $this->pageTitle = '积分统计';

        $start = Yii::app()->request->getParam('start');
        $end = Yii::app()->request->getParam('end');
        $type = Yii::app()->request->getParam('type');
        //$monthYear = !empty($getmonth)?$getmonth:date('Y-m');

        $criteria=new CDbCriteria;
        $criteria->select = '*';
        $criteria->addCondition("t.log_type = :log_type");
        $criteria->params[':log_type'] = 1;
        $criteria->addCondition("t.valid = :valid");
        $criteria->params[':valid'] = 1;
        //$criteria->addCondition("FROM_UNIXTIME(UNIX_TIMESTAMP(t.createdTime),'%Y-%m') = :date");
        if(!empty($start) && !empty($end))
        {
            $criteria->compare('UNIX_TIMESTAMP(t.createdTime) >',strtotime($_GET['start']));
            $criteria->compare('UNIX_TIMESTAMP(t.createdTime) <',strtotime($_GET['end'])+86400);
        }

        $model = PointLog::model()->with(array('user'))->findAll($criteria);

        $point_tmp = array();
        foreach($model as $key => $value)
        {
            $point_tmp[$value->user->code][] = $value;
        }

        $point_arr = array();
        foreach($point_tmp as $key => $value)
        {
            $tmp_value = 0;
            $tmp_account = '';
            foreach($value as $key1 => $value1)
            {
                $tmp_value += $value1->log_point;
                $tmp_account = $value1->user->account;
            }
            $point_arr[$key]['account'] = $tmp_account;
            $point_arr[$key]['userId'] = $value[0]->userId;
            $point_arr[$key]['point'] = $tmp_value;
        }

        if($type == 'excel')
        {
            $objectPHPExcel = new PHPExcel();
            $objectPHPExcel->setActiveSheetIndex(0);
            $objectPHPExcel->getActiveSheet()->mergeCells('A1:B1');
            $objectPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objectPHPExcel->getActiveSheet()->setCellValue('A1','统计时间：'.$start.'至'.$end);
            $objectPHPExcel->getActiveSheet()->setCellValue('A2','账户');
            $objectPHPExcel->getActiveSheet()->setCellValue('B2','积分值');
            $i=3;
            foreach($point_arr as $key => $value)
            {
                $objectPHPExcel->getActiveSheet()->setCellValue('A'.$i,$value['account']);
                $objectPHPExcel->getActiveSheet()->setCellValue('B'.$i,$value['point']);
            }
            ob_end_clean();
            ob_start();
            header('Content-Type : application/vnd.ms-excel');
            header('Content-Disposition:attachment;filename="积分统计.xls"');
            $objWriter= PHPExcel_IOFactory::createWriter($objectPHPExcel,'Excel5');
            $objWriter->save('php://output');

        }

        $this->render('point',array('point_arr'=>$point_arr,'start'=>$start,'end'=>$end));
    }

    public function actionSyslog()
    {
        $this->pageTitle = '最新动态';
        $model = new SysLog();
        $model->unsetAttributes();
        if(isset($_GET)&&!empty($_GET))
            $model->attributes=$_GET;
        $this->render('syslog',array('model'=>$model));
    }


}