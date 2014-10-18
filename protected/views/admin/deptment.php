12
<?php
  $this->widget('application.extensions.jqgrid.EJqGrid',

    JqGridWidget::widget ([
    'gridSettings'  =>  [
        'colNames'  =>  [ 'Title' ,  'Author' ,  'Language' ],
        'colModel'  =>  [
            [ 'name'  =>  'title' ,  'index'  =>  'title' ,  'editable'  =>  true ],
            [ 'name'  =>  'author' ,  'index'  =>  'author' ,  'editable'  =>  true ],
            [ 'name'  =>  'language' ,  'index'  =>  'language' ,  'editable'  =>  true ]
        ],
        'rowNum'  =>  15 ,
        'autowidth'  =>  true ,
        'height'  =>  'auto' ,
    ],
    'pagerSettings'  =>  [
        'edit'  =>  true ,
        'add'  =>  true ,
        'del'  =>  true ,
        'search'  =>  [ 'multipleSearch'  =>  true ]
    ],
    'enableFilterToolbar'  =>  true
]);
              array(
                    'name'=>'jqgrid1',
                    'compression'=>'none',
                    'theme'=>'redmond',
                    'useNavBar'=>true,
                    //'useNavBar'=>'false',
                    'options'=>array(
                                     'datatype'=>'xml',
                                     'url'=>'http://localhost/~metayii/yii-svn/demos/helloworld2/?r=site/list',
                                     'colNames'=>array('Index','Aircraft','BuiltBy'),
                                     'colModel'=>array(
                                                       array('name'=>'id','index'=>'id','width'=>'55','name'=>'invdate','index'=>'invdate','width'=>90),
                                                       array('name'=>'aircraft','index'=>'aircraft','width'=>90),
                                                       array('name'=>'factory','index'=>'factory','width'=>100)
                                                      ),
                                     'rowNum'=>10,
                                     'rowList'=>array(10,20,30),
                                     'sortname'=>'id',
                                     'viewrecords'=>true,
                                     'sortorder'=>"desc",
                                     'caption'=>"Airplanes from XML"
                                    )
                   )
             );
?>