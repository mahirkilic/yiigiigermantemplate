<?php

/**
 * CGridViewForm class file.
 *
 * @author Mahir Kilic (kilic_mahir@hotmail.com)
 * @copyright Copyright &copy; 2012 Cosco
 *
 */
Yii::import("zii.widgets.grid.CGridView");

class CGridViewForm extends CGridView {
    public $actions=array();
    /**
     * Initialize the widget
     */
    public function init() {
        if(!(is_array($this->columns[0]) and $this->columns[0]['class'] == 'CCheckBoxColumn')){
            array_unshift($this->columns, array(
                'class' => 'CCheckBoxColumn',
                'id' => 'id', ));
        }
        //print_r($this->columns);
        parent::init();
        $this->selectableRows = 2;
        $this->template = "{items}\n{summary}{pager}";
        $this->summaryCssClass = "summary left";
        if(count($this->actions)== 0){
             $this->actions = array(' ' => ' ', 'create' => Yii::t('application', 'Erstellen'), 'delete' => Yii::t('application', 'Löschen'),);

        }
    }

    /**
     * Run the widget
     */
    public function run() {
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'admin-form',
            'enableAjaxValidation' => false,
                ));
        echo "<span class='right bottom ' >
            <span style='margin-right: 15px;'>".Yii::t('application', 'pro Seite').": ";
        $pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
        echo CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
                                  'onchange'=>"$.fn.yiiGridView.update('".$this->id."',{ data:{pageSize: $(this).val() }})",
                    )); 
        echo "</span>
                <span>".Yii::t('application', 'Action')."</span> ";
        echo CHtml::dropDownList('action', '', $this->actions);
        $this->widget('zii.widgets.jui.CJuiButton', array(
            'name' => 'actionExecute',
            'buttonType' => 'button',
            'caption' => 'Go',
            'onclick' => 'js:function(){
                                if($("#action").val() == "delete"){
                                    check = confirm("'.Yii::t('application', 'Wollen Sie wirklich alle ausgewählte Einträge löschen?').'");
                                    if (check == false){
                                        return;
                                    }
                                }
                                $("#admin-form").submit();
                            }',
            'htmlOptions' => array(
                'style' => 'font-size:0.7em;'
            ),
        ));
        echo "</span>";
        parent::run();
        $this->endWidget();
    }

}